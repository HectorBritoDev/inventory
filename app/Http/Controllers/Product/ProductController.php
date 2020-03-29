<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Resources\ProductCollection;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    public function index()
    {
        return new ProductCollection(Product::all());
    }

    public function store(StoreProduct $request)
    {
        $product = Product::create($request->validated());
        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductCollection(Product::all());
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        $product->destroy();
        return [];
    }
}
