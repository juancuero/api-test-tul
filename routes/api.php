<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\v1\ProductController;
use App\Http\Controllers\v1\CartController;
use App\Http\Controllers\v1\CategoryController;

 
Route::apiResource('products', ProductController::class);

Route::group([
    'prefix' => 'cart'
], function () {
    Route::get('/show', [CartController::class, 'show'])->name('cart-show');  
    Route::post('/confirm', [CartController::class, 'confirm'])->name('cart-confirm');  
    Route::put('/{product}/remove', [CartController::class, 'remove'])->name('cart-remove');  
    Route::post('/{product}/add', [CartController::class, 'store'])->name('cart-store');  

});  


Route::put('categories/{category}/changestatus', [CategoryController::class, 'changeStatus'])->name('categories-changestatus');   
Route::apiResource('categories', CategoryController::class);

