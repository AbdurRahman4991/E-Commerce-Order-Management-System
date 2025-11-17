<?php
namespace App\Repositories;
use App\Models\Product;
use DB;

class ProductRepository
{
    public function all($filters)
    {
        $query = Product::with('variants');

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        return $query->paginate(15);
    }

    public function create(array $data)
    {
        
        return DB::transaction(function () use ($data) {
            $product = Product::create($data);

            foreach ($data['variants'] as $variant) {
                $product->variants()->create($variant);
            }

            return $product->load('variants');
        });
    }
}
