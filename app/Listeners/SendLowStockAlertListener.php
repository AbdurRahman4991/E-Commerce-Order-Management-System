<?php

namespace App\Listeners;

use App\Events\LowStockDetectedEvent;
use App\Jobs\SendLowStockAlertJob;

class SendLowStockAlertListener
{
    public function handle(LowStockDetectedEvent $event)
    {
        SendLowStockAlertJob::dispatch($event->variant);
    }
}
