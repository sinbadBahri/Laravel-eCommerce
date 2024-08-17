<?php

use App\Http\Controllers\ProfileController;
use App\Models\Widgets\ProductWidget;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $product_widget = ProductWidget::with('products.images')->where('is_active', true)->first();

    return view('welcome', compact('product_widget'));});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
