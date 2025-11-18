<?php

namespace App\Listeners;

use App\Events\OrderStatusChangedEvent;
use App\Jobs\GenerateInvoicePdfJob;

class GenerateInvoiceListener
{
    public function handle(OrderStatusChangedEvent $event)
    {
        if ($event->newStatus === 'delivered') {
            GenerateInvoicePdfJob::dispatch($event->order->id);

        }
    }
}
