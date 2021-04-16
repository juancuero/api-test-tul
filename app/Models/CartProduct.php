<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
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

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function gettotalAttribute()
    {
         return $this->price_unit * $this->quantity;
    }

     
}
