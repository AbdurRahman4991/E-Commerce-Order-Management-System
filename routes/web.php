<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

Route::get('/home', function () {
    $order = Order::with('items.variant.product', 'user')->find(1);

    
    $pdf = Pdf::loadView('pdf.invoice', [
        'order' => $order
    ]);

    
    $filePath = 'pdfs/invoice_order_'.$order->id.'.pdf';
    Storage::disk('public')->put($filePath, $pdf->output());

    return "PDF successfully stored at: " . storage_path('app/public/' . $filePath);
});

