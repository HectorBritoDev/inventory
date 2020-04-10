<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\Sale as SaleResource;
use App\Http\Resources\SaleCollection;
use App\Product;
use App\Sale;
use App\SaleItem;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    use ApiResponser;
    public function index()
    {
        return new SaleCollection(Sale::all());
    }

    public function store(SaleRequest $request)
    {
        try {
            DB::beginTransaction();
            $sale = Sale::create($request->validated());
            $items = $this->prepareArrayToInsertion($request->items, $sale->id);
            $total_price = collect($items)->pluck('total')->sum();
            $sale->update(['total_price' => $total_price]);
            SaleItem::insert($items);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $code = method_exists($th, 'getStatusCode') ? $th->getStatusCode() : 500;
            return $this->errorResponse($th->getMessage(), $code);
        }
        return new SaleResource($sale->load('items'));
    }

    public function show(Sale $sale)
    {
        return new SaleResource($sale);
    }

    public function update(Request $request, Sale $sale)
    {
        //
    }

    public function prepareArrayToInsertion($items, $saleId)
    {
        $preparedItems = [];

        foreach ($items as $key => $item) {
            $product = Product::findOrFail($item['product_id']);

            if ($product->quantity < $item['quantity']) {
                abort(422, 'stock of ' . $product->name . ' has only ' . $product->quantity . ' available. Trying to sell ' . $item['quantity']);
            }

            $price = ($product->minimum_to_mayoritary_price >= $item['quantity']) ? $product->mayor_price : $product->unit_price;
            $preparedItems[] = [
                'sale_id' => $saleId,
                'name' => $product->name,
                'quantity' => $item['quantity'],
                'discount' => $discount = $this->discount($item, $price),
                'price' => $total = $price - $discount,
                'total' => $total * $item['quantity'],
            ];
            $product->decrement('quantity', $item['quantity']);
        }
        return $preparedItems;

    }

    public function discount($item, $product_price)
    {
        if (array_key_exists('discount_type', $item)) {

            $type = $item['discount_type'];
            $discount = $item['discount'];

            if ($type === 'number' && $discount > $product_price) {
                abort(422, 'The discount of cant be greater than the product price');
            }
            return $this->calculateDiscount($product_price, $discount, $type);
        }
        return null;
    }

    public function calculateDiscount($product_price, $discount, $type)
    {
        return ($type === 'percentage') ? ($product_price * $discount) / 100 : $discount;
    }
}
