<?php

namespace App\Observers;

use App\Product;
use App\Purchase;
use App\PurchaseItem;

class PurchaseObserver
{
    /**
     * Handle the purchase "created" event.
     *
     * @param  \App\Purchase  $purchase
     * @return void
     */
    public function created(Purchase $purchase)
    {
        $request = request();
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
    }

    /**
     * Handle the purchase "updated" event.
     *
     * @param  \App\Purchase  $purchase
     * @return void
     */
    public function updated(Purchase $purchase)
    {
        //
    }

    /**
     * Handle the purchase "deleted" event.
     *
     * @param  \App\Purchase  $purchase
     * @return void
     */
    public function deleted(Purchase $purchase)
    {
        //
    }

    /**
     * Handle the purchase "restored" event.
     *
     * @param  \App\Purchase  $purchase
     * @return void
     */
    public function restored(Purchase $purchase)
    {
        //
    }

    /**
     * Handle the purchase "force deleted" event.
     *
     * @param  \App\Purchase  $purchase
     * @return void
     */
    public function forceDeleted(Purchase $purchase)
    {
        //
    }
}
