<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class LowStockMail extends Mailable
{
    public $variant;

    public function __construct($variant)
    {
        $this->variant = $variant;
    }

    public function build()
    {
        return $this->subject("Low Stock Alert: {$this->variant->product->name}")
                    ->markdown('emails.lowstock.alert');
    }
}
