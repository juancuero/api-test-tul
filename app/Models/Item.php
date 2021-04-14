<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_unit',
        'cart_id',
        'product_id',
        'quantity' 
    ];

    protected $appends = ['total'];

    protected $with = ['product'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function gettotalAttribute()
    {
         return $this->price_unit * $this->quantity;
    }

    public function items()
    {
        return $this->belongsTo(Item::class);
    }
}
