<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    public function index()
    {
        return $this->showAll(Product::all());
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        return $this->showOne(Product::all());
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
