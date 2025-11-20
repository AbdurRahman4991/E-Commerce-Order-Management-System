<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\v1\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Actions\CreateProductAction;
use App\Models\Product;


class ProductController extends Controller
{
      public function index(Request $req)
    {
        $products = app(ProductService::class)->listProducts($req->all());
        return ApiResponse::success($products);
    }

    public function store(ProductRequest $req)
    {        
        $product = (new CreateProductAction)($req->validated());
        return ApiResponse::created($product);
    }


    public function show(Product $product)
    {
        return ApiResponse::success($product->load('variants'));
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file')->getRealPath();

        $import = app(\App\Services\ProductImportService::class);
        $result = $import->import($file);

        return response()->json([
            'status' => true,
            'message' => 'Product import completed',
            'summary' => $result
        ]);
    }


}
