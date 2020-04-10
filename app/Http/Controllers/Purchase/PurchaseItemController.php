<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Resources\Purchase as PurchaseResource;
use App\Http\Resources\PurchaseItemCollection;
use App\Purchase;
use App\PurchaseItem;

class PurchaseItemController extends Controller
{

    public function index($id)
    {
        return request()->with === 'purchase'
        ? new PurchaseResource(Purchase::find($id)->load('items'))
        : new PurchaseItemCollection(PurchaseItem::wherePurchaseId($id)->get());

        // return new PurchaseItemCollection(PurchaseItem::wherePurchaseId($id)->get());
        // return new PurchaseCollection(Purchase::all()->load('items'));
    }

    public function show($id)
    {
        return request()->with === 'purchase'
        ? new PurchaseItemCollection(PurchaseItem::wherePurchaseId($id)->get())
        : new PurchaseResource(Purchase::find($id)->load('items'));
    }

}
