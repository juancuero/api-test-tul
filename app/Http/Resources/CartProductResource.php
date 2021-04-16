<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResource extends JsonResource
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
            'price_unit' => (double) $this->price_unit,
            'quantity' => (int) $this->quantity,
            'total' => (int) $this->quantity * (double) $this->price_unit,
            'product' => new ProductResource($this->product),
        ];
    }
}

 