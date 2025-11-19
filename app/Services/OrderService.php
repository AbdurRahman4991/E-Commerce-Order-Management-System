<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(array $data, $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $total = 0;

            // create order
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'total' => 0
            ]);

            foreach ($data['items'] as $item) {
                $variant = ProductVariant::findOrFail($item['variant_id']);

                if ($variant->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for variant {$variant->sku}");
                }

                // Deduct stock
                $variant->decrement('stock', $item['quantity']);

                // 🔥 LOW STOCK CHECK → trigger event
                if ($variant->stock <= $variant->low_stock_threshold) {
                    event(new LowStockDetectedEvent($variant));
                }

                // Calculate total
                $itemTotal = $variant->price * $item['quantity'];
                $total += $itemTotal;

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $item['quantity'],
                    'price' => $variant->price,
                ]);
            }

            // Update order total
            $order->update(['total' => $total]);

            return $order->load('items.variant');
        });
    }

    public function updateStatus(Order $order, string $status)
    {
        return DB::transaction(function () use ($order, $status) {
            $oldStatus = $order->status;
            $order->update(['status' => $status]);

            // Rollback stock if cancelled
            if ($status === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    $item->variant->increment('stock', $item->quantity);
                }
            }

            return $order->fresh('items.variant');
        });
    }
}
