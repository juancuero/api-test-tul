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

    protected $attributes = ['active' => true];

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

/* DOCUMENTATION  */    

/**
 * @OA\Schema(
 * schema="ProductCreate",
    * description="<b> Register Product model</b> <br>",
    * @OA\Property(title="Name",property="name",description="Name of the product",type="string",example="Mi producto"),
    * @OA\Property(title="Description",property="description",description="Description of the product",type="string",example="Hola esta es mi primer producto"), 
    * @OA\Property(title="Stock",property="stock",description="stock of the product",type="integer",example=20), 
    * @OA\Property(title="Price",property="price",description="price of the product",type="decimal",example=50000), 
    * @OA\Property(title="Category",property="category_id",description="Category of the product",type="integer",example=3),
    * @OA\Property(title="Image",property="image",description="Image of the product",format="binary",type="string"),
 * )
 */
