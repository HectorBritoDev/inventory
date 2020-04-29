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
        $category = $this->category_id != null;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'available' => $this->quantity,
            'unitary_price' => $this->unit_price,
            'mayoritary_price' => $this->mayor_price,
            'purchased_price' => $this->purchase_price,
            'category_url' => $this->when($category, function () {
                return route('categories.show', $this->category_id);
            }),
            'stadistics' => [
                'last_time_purchased' => $this->purchases->count() > 0 ? $this->purchases->first()->last_time_purchased : 'never purchased',
                'total_units_sold' => $this->sales->count() > 0 ? $this->sales->first()->total_units_sold : 0,
            ],
        ];
        // return parent::toArray($request);
    }
}
