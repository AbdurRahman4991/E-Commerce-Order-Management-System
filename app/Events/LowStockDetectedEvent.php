<?php

namespace App\Events;

use App\Models\ProductVariant;
use Illuminate\Foundation\Events\Dispatchable;

class LowStockDetectedEvent
{
    use Dispatchable;

    public $variant;

    public function __construct(ProductVariant $variant)
    {
        $this->variant = $variant;
    }
}
