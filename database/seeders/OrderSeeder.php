<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customerId = 3; // customer user id

        $variant1 = ProductVariant::first();
        $variant2 = ProductVariant::skip(1)->first();

        $order = Order::create([
            'user_id' => $customerId,
            'status' => 'pending',
            'total' => ($variant1->price * 1) + ($variant2->price * 2)
        ]);

        // Order Items
        OrderItem::create([
            'order_id' => $order->id,
            'product_variant_id' => $variant1->id,
            'quantity' => 1,
            'price' => $variant1->price
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_variant_id' => $variant2->id,
            'quantity' => 2,
            'price' => $variant2->price
        ]);

        // Stock Deduct
        $variant1->decrement('stock', 1);
        $variant2->decrement('stock', 2);
    }
}
