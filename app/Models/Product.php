<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'image',
        'stock',
        'category_id',
        'price',
        'active' 
    ];

    protected $appends = ['categoryName'];


    protected $hidden = [ 
        'category', 
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getcategoryNameAttribute()
    {
         return $this->category->name;
    }

    public function scopeavailables($query)
    {
        $query->where('products.active', true)
                ->where('stock','>', 0)
                ->where('price','>', 0)->select('products.*');

        $query->join('categories as second', 'second.id', '=', 'products.category_id')
            ->join('categories as principal', 'principal.id', '=', 'second.parent_id')
            ->where('second.active', true)
            ->where('principal.active', true);

        return $query;
    }


}
