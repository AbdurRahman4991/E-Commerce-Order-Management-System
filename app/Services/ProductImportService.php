<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class ProductImportService
{
    public function import($file)
    {
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);

        $summary = [
            'created' => 0,
            'updated' => 0,
            'failed_rows' => []
        ];

        $requiredColumns = ['name', 'sku', 'price', 'stock'];

        foreach ($requiredColumns as $col) {
            if (!in_array($col, $header)) {
                return [
                    'status' => false,
                    'message' => "Missing required column: {$col}"
                ];
            }
        }

        $rowNumber = 1;

        while (($data = fgetcsv($handle)) !== false) {
            $rowNumber++;

            if (count($data) < count($header)) {
                $summary['failed_rows'][] = [
                    'row' => $rowNumber,
                    'error' => 'Invalid row format'
                ];
                continue;
            }

            $row = array_combine($header, $data);

            try {
                // 1️⃣ Create or find Product
                $product = Product::firstOrCreate(
                    [
                        'name' => $row['name']
                    ],
                    [
                        'vendor_id' => auth()->id(),
                        'slug' => Str::slug($row['name']),
                        'description' => $row['description'] ?? null,
                    ]
                );

                // 2️⃣ Create or update Variant
                $variant = ProductVariant::updateOrCreate(
                    ['sku' => $row['sku']],
                    [
                        'product_id' => $product->id,
                        'attribute' => $row['attribute'] ?? 'default',
                        'price' => $row['price'],
                        'stock' => $row['stock'],
                        'low_stock_threshold' => $row['low_stock_threshold'] ?? 10,
                    ]
                );

                if ($variant->wasRecentlyCreated) {
                    $summary['created']++;
                } else {
                    $summary['updated']++;
                }

            } catch (\Exception $e) {
                $summary['failed_rows'][] = [
                    'row' => $rowNumber,
                    'error' => $e->getMessage()
                ];
            }
        }

        fclose($handle);

        return $summary;
    }
}
