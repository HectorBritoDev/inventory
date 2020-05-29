<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            'code'=>$this->code,
            'name' => $this->name,
            'available' => $this->quantity,
            'unitary_price' => $this->unit_price,
            'mayoritary_price' => $this->mayor_price,
            'purchased_price' => $this->purchase_price,
            // 'category_url' => $this->when($this->category_id != null, function () {
            //     return route('categories.show', $this->category_id);
            // }),
            'category' => $this->when($this->category_id != null, function () {
                return $this->category->name;
            }),
            'stadistics' => [
                'last_time_purchased' => $this->purchases->count() > 0 ? $this->purchases->first()->last_time_purchased : 'never purchased',
                'total_units_sold' => $this->sales->count() > 0 ? $this->sales->first()->total_units_sold : 0,
                'total_price_sold_ever' => $this->sales->count() > 0 ? $this->sales->first()->total_price_sold_ever : 0,
                'times_sold_with_discount' => $this->sales->count() > 0 ? $this->sales->first()->times_sold_with_discount : 0,
            ],
        ];
        // return parent::toArray($request);
    }
}
