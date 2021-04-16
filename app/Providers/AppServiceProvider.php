<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\ProductObserver; 
use App\Observers\CartProductObserver; 
use App\Observers\CartObserver; 
use App\Models\Product;
use App\Models\CartProduct;
use App\Models\Cart;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ProductObserver::class); 
        CartProduct::observe(CartProductObserver::class); 
        Cart::observe(CartObserver::class); 
    }
}
