<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use App\Http\Controllers\Api\v1\Helpers\ApiResponse;
use App\Models\Order;
use App\Events\OrderStatusChangedEvent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
     use AuthorizesRequests;
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = auth()->user()->role_id == 1 
                    ? Order::with('items.variant')->latest()->get() 
                    : auth()->user()->orders()->with('items.variant')->latest()->get();

        return ApiResponse::success($orders);
    }

    public function store(OrderRequest $request)
    {
        $order = $this->orderService->createOrder($request->validated(), auth()->id());
        return ApiResponse::created($order);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return ApiResponse::success($order->load('items.variant'));
    }

    // public function updateStatus(Order $order, $status)
    // {
    //     $order = $this->orderService->updateStatus($order, $status);
    //     return ApiResponse::success($order);
    // }
    public function updateStatus(Order $order, $newStatus)
    {
        $oldStatus = $order->status;

        $order->update([
            'status' => $newStatus
        ]);

        // === Fire Event ===
        event(new OrderStatusChangedEvent($order, $oldStatus, $newStatus));

        return $order->fresh();
    }

}
