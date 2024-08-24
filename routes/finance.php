<?php

use App\Http\Controllers\Finance\BasketController;
use Illuminate\Support\Facades\Route;

Route::get('/basket', [BasketController::class,'index'])->name('basket');
Route::post('/basket/add', [BasketController::class, 'add']);
Route::get('/basket/clear-all', [BasketController::class,'delete']);