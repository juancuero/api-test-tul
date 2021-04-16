<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'active' 
    ];

    protected $attributes = ['active' => true];


    public function children(){
        return $this->hasMany(Category::class,"parent_id");
    }

    public function scopelistPrincipal($query)
    {
        $query->where('parent_id', null);
        return $query;
    }

   
}

/* DOCUMENTATION  */    

/**
 * @OA\Schema(
 * schema="CategoryCreate",
    * description="<b> Register Category model</b> <br>",
    * @OA\Property(title="Name",property="name",description="Name of the category",type="string",example="Materiales de Construcción"),
    * @OA\Property(title="Parent",property="parent_id",description="Parent of the category",type="integer",example=null),
 * )
 */
