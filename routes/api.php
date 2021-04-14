<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::group([
    'prefix' => 'products'
], function () {


    Route::get('/', [ProductController::class, 'index'])->name('products-index');  
    
    

});   

Route::group([
    'prefix' => 'cart'
], function () {
    Route::get('/', [CartController::class, 'show'])->name('cart-show');  
    Route::post('/{product}', [CartController::class, 'store'])->name('cart-store');  

});       