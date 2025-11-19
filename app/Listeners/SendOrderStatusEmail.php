<?php

namespace App\Listeners;

use App\Events\OrderStatusChangedEvent;
use App\Mail\OrderStatusChangedMail;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusEmail
{
    public function handle(OrderStatusChangedEvent $event)
    {
        $order = $event->order;
        $user  = $order->user;

        Mail::to($user->email)->send(
            new OrderStatusChangedMail($order, $event->oldStatus, $event->newStatus)
        );
    }
}
