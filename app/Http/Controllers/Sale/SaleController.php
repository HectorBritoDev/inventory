<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Sale as SaleResource;
use App\Http\Resources\SaleCollection;
use App\Sale;
use Illuminate\Http\Request;

class SaleController extends ApiController
{
    public function index()
    {
        return new SaleCollection(Sale::all());
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Sale $sale)
    {
        return new SaleResource(Sale::all());
    }

    public function update(Request $request, Sale $sale)
    {
        //
    }

    public function destroy(Sale $sale)
    {
        //
    }
}
