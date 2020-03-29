<?php

namespace App\Http\Resources;

use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
        return parent::toArray($request);
    }
}
