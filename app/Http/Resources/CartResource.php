<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'amount' => (double) $this->total,
            'status' => $this->status,
            'total_products' => $this->items->count(), 
            'items' => CartProductResource::collection($this->whenLoaded('items')),
        ];
    }
}
