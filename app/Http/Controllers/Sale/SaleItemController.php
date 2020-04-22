<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Resources\Sale as SaleResource;
use App\Http\Resources\SaleItemCollection;
use App\Sale;
use App\SaleItem;
use Illuminate\Support\Facades\DB;

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

    }
    public function topProduct($how_many = 100)
    {
        return SaleItem::select('name', DB::raw('SUM(quantity) as quantity'))
            ->groupBy('name')
            ->orderBy('quantity', 'DESC')
            ->limit($how_many)
            ->get();
    }

}
