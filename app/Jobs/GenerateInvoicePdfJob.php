<?php

namespace App\Jobs;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateInvoicePdfJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }


   public function handle()
{
    try {

        $order = \App\Models\Order::with(['items.product', 'items.variant', 'user'])
            ->findOrFail($this->orderId);

        $pdf = Pdf::loadView('pdf.invoice', [
            'order' => $order,
        ]);

        $fileName = 'invoice_' . $order->id . '_' . time() . '.pdf';
        $savePath = storage_path('app/invoices/' . $fileName);

        if (!is_dir(storage_path('app/invoices'))) {
            mkdir(storage_path('app/invoices'), 0777, true);
        }

        $pdf->save($savePath);

        Invoice::create([
            'order_id' => $order->id,
            'pdf_path' => 'invoices/' . $fileName
        ]);

    } catch (\Exception $e) {

        \Log::error("========== INVOICE PDF ERROR ==========");
        \Log::error("Message: " . $e->getMessage());
        \Log::error("File: " . $e->getFile());
        \Log::error("Line: " . $e->getLine());
        \Log::error("Stack: " . $e->getTraceAsString());
    }
}

}
