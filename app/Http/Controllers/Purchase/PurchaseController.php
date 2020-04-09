<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\Purchase as PurchaseResource;
use App\Http\Resources\PurchaseCollection;
use App\Product;
use App\Purchase;
use App\PurchaseItem;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return new PurchaseCollection(Purchase::all());
    }

    public function store(PurchaseRequest $request)
    {
        try {
            DB::beginTransaction();
            $purchase = Purchase::create([]);
            $items = $this->prepareArrayToInsert($request->items, $purchase->id);
            PurchaseItem::insert($items);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 500);
        }
        return new PurchaseResource($purchase->load('items'));
    }

    public function show(Purchase $purchase)
    {
        return new PurchaseResource(Purchase::all());
    }

    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    public function prepareArrayToInsert($items, $purchase_id)
    {
        $preparedItems = [];
        foreach ($items as $key => $item) {
            $product = Product::findOrFail($item['product_id']);
            $product->increment('quantity', $item['quantity']);
            $preparedItems[] = [
                'purchase_id' => $purchase_id,
                'name' => $product->name,
                'quantity' => $item['quantity'],
            ];
        }

        return $preparedItems;

    }

}
