<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\ApiController;
use App\Sale;
use Illuminate\Http\Request;

class SaleController extends ApiController
{
    public function index()
    {
        return $this->showAll(Sale::all());
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Sale $sale)
    {
        return $this->showOne(Sale::all());
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
