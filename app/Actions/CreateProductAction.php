<?php
namespace App\Actions;

use App\Services\ProductService;
use Illuminate\Support\Str;

class CreateProductAction
{
    public function __invoke(array $data)
    {
        $data['slug'] = Str::slug($data['name']) . '-' . rand(1000, 9999);

        return app(ProductService::class)->createProduct($data);
    }
}
