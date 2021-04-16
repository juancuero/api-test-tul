<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\CategoryResource;

class ProductResource extends JsonResource
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
        'name' => $this->name,
        'sku' => $this->sku,
        'description' => $this->description,
        'image' => $this->image,
        'stock' => (int) $this->stock,
        'price' => (double) $this->price,
        'category' => new CategoryResource($this->category),
        'active' => $this->active
    ];
    }
}
