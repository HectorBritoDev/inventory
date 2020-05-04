<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use App\Product;
use App\PurchaseItem;
use App\SaleItem;
use App\Traits\ApiResponser;

class ProductController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $products = Product::with([
            'sales' => function ($query) {
                $query->selectRaw('product_id,SUM(quantity) as total_units_sold, SUM(total) as total_price_sold_ever, COUNT(discount) as times_sold_with_discount')->groupBy('product_id');
            },
            'purchases' => function ($query) {
                $query->selectRaw('product_id, MAX(created_at) as last_time_purchased')->groupBy('product_id');
            },
        ])
            ->get();

        return new ProductCollection($products);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        // $product->load([
        //     'sales' => function ($query) use ($product) {
        //         $query->selectRaw('product_id,SUM(quantity) as total_units_sold')->whereProductId($product->id)->groupBy('product_id');
        //     },
        //     'purchases' => function ($query) use ($product) {
        //         $query->selectRaw('product_id, MAX(created_at) as last_time_purchased')->whereProductId($product->id)->groupBy('product_id');
        //     },
        // ]);

        $product->sales = SaleItem::selectRaw('product_id,SUM(quantity) as total_units_sold, SUM(total) as total_price_sold_ever,COUNT(discount) as times_sold_with_discount')->whereProductId($product->id)->groupBy('product_id')->get();
        $product->purchases = PurchaseItem::selectRaw('product_id, MAX(created_at) as last_time_purchased')->whereProductId($product->id)->groupBy('product_id')->get();

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
