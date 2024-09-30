<?php


use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('mainPage');
Route::get('/cart-items', [MainController::class, 'reloadCartItems']);


require __DIR__.'/auth.php';
require __DIR__.'/profile.php';
require __DIR__.'/blog.php';
require __DIR__.'/finance.php';
require __DIR__.'/admin.php';