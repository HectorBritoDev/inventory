<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StorePurchase;
use App\Http\Resources\Purchase as PurchaseResource;
use App\Http\Resources\PurchaseCollection;
use App\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends ApiController
{
    public function index()
    {
        return new PurchaseCollection(Purchase::all());
    }

    public function store(StorePurchase $request)
    {
        $purchase = Purchase::create($request->validated());
        return new PurchaseResource($purchase);
    }

    public function show(Purchase $purchase)
    {
        return new PurchaseResource(Purchase::all());
    }

    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return $this->successResponse([]);
    }
}
