<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\SaleItem;
class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->sales->first()->quantity);
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'avaliable' => $this->quantity,
            'unitary_price' => $this->unit_price,
            'mayoritary_price' => $this->mayor_price,
            'purchased_price' => $this->purchase_price,
            'category_url' => $this->category_id ? route('categories.show', $this->category_id) : null,
            'times_sold'=>  $this->sales->count()>0 ? $this->sales->first()->quantity_units : 0 
            ];
        // return parent::toArray($request);
    }
}
