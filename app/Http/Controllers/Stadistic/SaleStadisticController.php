<?php

namespace App\Http\Controllers\Stadistic;

use App\Http\Controllers\Controller;
use App\Http\Resources\SaleItemCollection;
use App\SaleItem;

class SaleStadisticController extends Controller
{
    public function topSellingProduct($how_many = 100)
    {
        return new SaleItemCollection(
            SaleItem::selectRaw('name, SUM(quantity) as quantity, SUM(total) as total')
                ->groupBy('name')
                ->orderBy('quantity', 'DESC')
                ->limit($how_many)
                ->get()
        );
    }
}
