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
            'name' => $this->name,
            'avaliable' => $this->quantity,
            'unitary_price' => $this->unit_price,
            'mayoritary_price' => $this->mayor_price,
            'purchased_price' => $this->purchase_price,
            'category_url' => route('categories.show', $this->category_id),
        ];
        return parent::toArray($request);
    }
}
