<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use App\Product;
use App\Traits\ApiResponser;

class ProductController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $products = Product::with(['sales'=> function($query){
            $query->selectRaw('product_id,SUM(quantity) as quantity_units')->groupBy('product_id');
        }])
        ->paginate(1000);
        
        return new ProductCollection($products);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->validated());

        if ($product->isClean()) {
            return $this->errorResponse('at least one value to update must be different', 422);
        }

        $product->save();
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->successResponse('deleted successfully');
    }
}
