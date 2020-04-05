<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Purchase extends JsonResource
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
            'date' => $this->created_at,
            'message' => $this->message,
            'items' => PurchaseItem::collection($this->whenLoaded('items')),
        ];
        return parent::toArray($request);
    }
}
