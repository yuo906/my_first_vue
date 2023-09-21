<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontController::class,'home'])->name('home');

Route::middleware('auth', 'verified')->group(function () {
    Route::post('/addCarts', [FrontController::class,'addCart'])->name('product.addCart');
    Route::get('/shopping-cart', [CartController::class,'shopping_cart'])->name('user.cart');

});
