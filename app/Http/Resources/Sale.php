<?php

namespace App\Http\Resources;

use App\Http\Resources\SaleItem as SaleItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Sale extends JsonResource
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
            'date' => $this->created_at->format('d-m-Y H:i:s'),
            'items' => SaleItemResource::collection($this->whenLoaded('items')),
            'message' => $this->message,
        ];
        return parent::toArray($request);
    }
}
