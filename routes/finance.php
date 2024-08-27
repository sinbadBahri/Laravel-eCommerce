<?php

use App\Http\Controllers\Finance\BasketController;
use App\Http\Controllers\Finance\CheckoutController;
use Illuminate\Support\Facades\Route;

################################ Basket ######################################

Route::get('/basket', [BasketController::class,'index'])->name('basket');
Route::post('/basket/add', [BasketController::class, 'add']);
Route::get('/basket/clear-all', [BasketController::class,'clearAll']);
Route::post('/basket/remove-product', [BasketController::class,'remove']);

################################ Checkout ######################################

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class,'index']);
    Route::post('/checkout', [CheckoutController::class,'checkout']);
});