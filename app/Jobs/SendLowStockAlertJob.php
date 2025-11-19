<?php

namespace App\Jobs;

use App\Mail\LowStockMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\Dispatchable;

class SendLowStockAlertJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $variant;

    public function __construct($variant)
    {
        $this->variant = $variant;
    }

    public function handle()
    {
        // Send email to admin/vendor
        $emails = ['admin@gmail.com']; // you can shift to config

        foreach ($emails as $email) {
            Mail::to($email)->send(new LowStockMail($this->variant));
        }
    }
}
