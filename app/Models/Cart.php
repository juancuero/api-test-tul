<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Cart extends Model
{
    use HasFactory;

    public $error;

    protected $fillable = [
        'status',
    ];

    protected $appends = ['amount','totalProducts'];
    
    public function items()
    {
        return $this->hasMany(CartProduct::class);
    }
    
    public function getamountAttribute()
    {
        $amount = CartProduct::all()->sum(function($t){ 
            return $t->price_unit * $t->quantity; 
        });

         return $amount;
    }

    public function gettotalProductsAttribute()
    {
        return $this->items->count();
    }
 
}
