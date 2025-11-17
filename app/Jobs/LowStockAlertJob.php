<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LowStockAlertJob implements ShouldQueue
{
    public function __construct(public ProductVariant $variant) {}

    public function handle()
    {
        // Email logic to vendor
        Mail::to($this->variant->product->vendor->email)
            ->send(new LowStockMail($this->variant));
    }
}
