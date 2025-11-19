<?php

namespace App\Jobs;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;

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
           

            $order = Order::with([
                'items.variant.product',
                'user'
            ])->find($this->orderId);
           

            // FOLDER CREATE
            $folderPath = storage_path('app/invoices');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // PDF GENERATE
            $fileName = 'invoice_' . $order->id . '_' . time() . '.pdf';
            $savePath = $folderPath . '/' . $fileName;

            $pdf = Pdf::loadView('pdf.invoice', [
                'order' => $order
            ]);

            $pdf->save($savePath);

            // DB INSERT
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
