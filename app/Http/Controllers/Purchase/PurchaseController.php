<?php

namespace App\Http\Controllers\Purchase;

use App\Product;
use App\Purchase;
use App\PurchaseItem;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePurchase;
use App\Http\Controllers\ApiController;
use App\Http\Resources\PurchaseCollection;
use App\Http\Resources\Purchase as PurchaseResource;

class PurchaseController extends ApiController
{
    use ApiResponser;

    public function index()
    {
        return new PurchaseCollection(Purchase::all());
    }

    public function store(StorePurchase $request)
    {
        try{
            DB::beginTransaction();
                $purchase = Purchase::create([]);
                $items = [];
                foreach ($request->items as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $product->increment('quantity', $item['quantity']);
                    $items[] = [
                        'purchase_id' => $purchase->id,
                        'name' => $product->name,
                        'price' => ($product->minimum_to_mayoritary_price >= $item['quantity']) ? $product->mayor_price : $product->unit_price,
                        'discount' => $item['discount'],
                        'quantity' => $item['quantity'],
                    ];
                }
                PurchaseItem::insert($items);
                DB::commit();
            } catch  (\Throwable $th){
                DB::rollback();
                return $this->errorResponse($th->getMessage(),500);
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

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return $this->successResponse([]);
    }
}
