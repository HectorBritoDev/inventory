<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\ApiController;
use App\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends ApiController
{
    public function index()
    {
        return $this->showAll(Purchase::all());
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Purchase $purchase)
    {
        return $this->showOne(Purchase::all());
    }

    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    public function destroy(Purchase $purchase)
    {
        //
    }
}
