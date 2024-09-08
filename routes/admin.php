<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {
    Route::get("/admin-panel", [AdminController::class,"index"]);
    Route::get("/admin-panel/products", function (){
        return view("admin.productList");
    });
});