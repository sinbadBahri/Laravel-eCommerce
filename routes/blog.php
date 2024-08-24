<?php

use App\Http\Controllers\Blog\CommentController;
use App\Http\Controllers\Blog\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/post/all/{genre}', [PostController::class,'index']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::post('/post/{id}/{comment_id}', [CommentController::class,'store']);