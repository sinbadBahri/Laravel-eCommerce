<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(
    function ()
    {
        Route::get("/admin-panel", [AdminController::class,"index"]);
        Route::get("/admin-panel/products", [ProductController::class,"index"]);
    }
    
);