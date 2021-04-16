<?php

namespace App\Observers;

use App\Models\Cart;

class CartObserver
{
    /**
     * Handle the Cart "created" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function created(Cart $cart)
    {
        //
    }

    /**
     * Handle the Cart "updated" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function updated(Cart $cart)
    {
        
       
    }

    /**
     * Handle the Cart "deleted" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function deleted(Cart $cart)
    {
        //
    }

    /**
     * Handle the Cart "restored" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function restored(Cart $cart)
    {
        //
    }

    /**
     * Handle the Cart "force deleted" event.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function forceDeleted(Cart $cart)
    {
        //
    }

    public function updating(Cart $cart)
    {  
        if($cart->status == "T"){
            foreach ($cart->items as $item) {

                if($item->quantity <= $item->product->stock){
                   
                    $item->product->stock = $item->product->stock - $item->quantity;
                    $item->product->save();
    
                }else{ 
                    $cart['error'] = 'No stock available product '.$item->product->sku; 
                    return false;
                    
                }
            }  
        }
    }


}
