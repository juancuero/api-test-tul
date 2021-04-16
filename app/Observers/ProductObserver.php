<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
  
    public function creating(Product $product)
    {
        $num = Product::count() + 1;
        $num = str_pad($num, 3, "0", STR_PAD_LEFT);
        $product->sku = "REF".$num;
    }
}
