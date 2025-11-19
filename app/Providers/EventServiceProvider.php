<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\OrderStatusChangedEvent;
use App\Listeners\GenerateInvoiceListener;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
            App\Events\OrderStatusChangedEvent::class => [
            App\Listeners\SendOrderStatusEmail::class,
            App\Listeners\SendLowStockAlertListener::class,
        ],
    ];


    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
