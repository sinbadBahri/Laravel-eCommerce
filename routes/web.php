<?php

use App\Http\Controllers\Blog\CommentController;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Models\Widgets\ProductWidget;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('mainPage');
Route::post('/update_item', [MainController::class,'updateItem']);
Route::get('/post/all/{genre}', [PostController::class,'index']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::post('/post/{id}/{comment_id}', [CommentController::class,'store']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
