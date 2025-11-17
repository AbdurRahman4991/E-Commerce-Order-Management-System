<?php
namespace App\Services;
use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $products
    ) {}

    public function listProducts($filters)
    {
        return $this->products->all($filters);
    }

    public function createProduct($data)
    {
        return $this->products->create($data);
    }
}
