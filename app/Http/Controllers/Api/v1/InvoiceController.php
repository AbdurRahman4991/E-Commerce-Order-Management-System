<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function download($orderId)
    {
        $invoice = Invoice::where('order_id', $orderId)->first();

        if (!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Invoice not found for this order.'
            ], 404);
        }

        $filePath = storage_path('app/' . $invoice->pdf_path);

        if (!file_exists($filePath)) {
            return response()->json([
                'status' => false,
                'message' => 'Invoice PDF file not found on server.'
            ], 404);
        }

        return response()->download($filePath);
    }
}
