<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;

Route::group([
    'prefix' => 'products'
], function () {


    Route::get('/', [ProductController::class, 'index'])->name('products-index');  
    Route::post('/', [ProductController::class, 'store'])->name('products-store');  
    
    

});   

Route::group([
    'prefix' => 'cart'
], function () {
    Route::get('/', [CartController::class, 'show'])->name('cart-show');  
    Route::post('/pay', [CartController::class, 'pay'])->name('cart-pay');  
    Route::post('/{product}/remove', [CartController::class, 'remove'])->name('cart-remove');  
    Route::post('/{product}', [CartController::class, 'store'])->name('cart-store');  

});     

Route::group([
    'prefix' => 'category'
], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category-index');  
    Route::post('/{category}/changestatus', [CategoryController::class, 'changeStatus'])->name('category-changestatus');   

});  