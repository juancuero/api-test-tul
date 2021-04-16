<?php

namespace App\Observers;
use Illuminate\Validation\ValidationException;
use App\Models\CartProduct;

class CartProductObserver
{
    /**
     * Handle the CartProduct "created" event.
     *
     * @param  \App\Models\CartProduct  $cartProduct
     * @return void
     */
    public function created(CartProduct $cartProduct)
    {
        $cartProduct->cart->total = $cartProduct->cart->amount;
        $cartProduct->cart->save();
    }

    /**
     * Handle the CartProduct "updated" event.
     *
     * @param  \App\Models\CartProduct  $cartProduct
     * @return void
     */
    public function updated(CartProduct $cartProduct)
    { 
        $cartProduct->cart->total = $cartProduct->cart->amount;
        $cartProduct->cart->save(); 
    }

    /**
     * Handle the CartProduct "deleted" event.
     *
     * @param  \App\Models\CartProduct  $cartProduct
     * @return void
     */
    public function deleted(CartProduct $cartProduct)
    {
        $cartProduct->cart->total = $cartProduct->cart->amount;
        $cartProduct->cart->save();
    }
 
}
