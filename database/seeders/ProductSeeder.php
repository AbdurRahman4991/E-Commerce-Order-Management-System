<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $vendorId = 2; // vendor user id

        $products = [
            [
                'name' => 'Smart Phone',
                'variants' => [
                    ['sku' => 'SP001', 'attribute' => 'color=Black', 'price' => 12000, 'stock' => 50],
                    ['sku' => 'SP002', 'attribute' => 'color=Blue', 'price' => 12500, 'stock' => 40],
                ]
            ],
            [
                'name' => 'Bluetooth Speaker',
                'variants' => [
                    ['sku' => 'BS001', 'attribute' => 'color=Red', 'price' => 2000, 'stock' => 60],
                ]
            ],
            [
                'name' => 'Laptop',
                'variants' => [
                    ['sku' => 'LP001', 'attribute' => 'ram=8GB', 'price' => 55000, 'stock' => 20],
                ]
            ]
        ];

        foreach ($products as $p) {
            $product = Product::create([
                'vendor_id' => $vendorId,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => $p['name'] . ' description.',
                'is_active' => true
            ]);

            foreach ($p['variants'] as $v) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $v['sku'],
                    'attribute' => $v['attribute'],
                    'price' => $v['price'],
                    'stock' => $v['stock'],
                    'low_stock_threshold' => 5
                ]);
            }
        }
    }
}
