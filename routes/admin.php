<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\FinanceAndPaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function ()
    {

        Route::prefix('admin-panel')->group(function ()
            {

                Route::get( "/", [AdminController::class,"index"],);

                Route::prefix('products')->group(function ()
                    {

                        Route::get( "/", [ProductController::class,"index"],);
                        Route::get("/add-product", [ProductController::class,"addProduct"], );
                        Route::get("/all-categories", [ProductController::class,"categoriesView"], );
                        Route::get("/attributes", [ProductController::class,"attributesView"], );

                    }
                );

                Route::prefix('blog')->group(function ()
                    {

                        Route::get( "/posts-list", [BlogController::class,"postsList"],);
                        Route::get( "/create-post", [BlogController::class,"create"], );

                    }
                );

                Route::prefix('users')->group(function ()
                    {

                        Route::get( "/", [UsersController::class,"index"],)->name("users");
                        Route::get( "/create-user", [UsersController::class,"create"], );
                        Route::post( "/create-user", [UsersController::class,"store"], );

                    }
                );

                Route::prefix('finance-payment')->group(function ()
                    {

                        Route::get( "/users-wallets", [FinanceAndPaymentController::class,"walletsView"],);
                        Route::get( "/users-orders", [FinanceAndPaymentController::class,"ordersView"],);
                        Route::get( "/users-payments", [FinanceAndPaymentController::class,"paymentsView"],);

                    }
                );
            }
        );

    }  
);