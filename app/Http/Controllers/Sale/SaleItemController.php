<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Resources\Sale as SaleResource;
use App\Http\Resources\SaleItemCollection;
use App\Sale;
use App\SaleItem;

class SaleItemController extends Controller
{
    public function index($id)
    {
        return request()->with === 'sale'
        ? new SaleResource(Sale::find($id)->load('items'))
        : new SaleItemCollection(SaleItem::whereSaleId($id)->get());

        // return new SaleItemCollection(SaleItem::whereSaleId($id)->get());
    }

    public function show(SaleItem $saleItem)
    {
        //
    }

}
