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

                Route::get( "/", [AdminController::class,"index"]);

                Route::prefix('products')->group(function ()
                    {
                        # Product & ProductLine
                        Route::get( "/", [ProductController::class,"index"]);
                        Route::post("/add-product-line", [ProductController::class, "storeProductLine"])
                        ->name('product_line.create');
                        Route::post('delete-product-line', [ProductController::class, "removeProductLine"])
                        ->name('product_line.delete');
                        Route::get("/add-product", [ProductController::class,"addProductForm"]);
                        Route::post("/add-product", [ProductController::class,"storeProduct"]);
                        Route::post('/add-brand', [ProductController::class, 'createNewBrand'])
                        ->name('brand.create');
                        Route::post('/add-product-type', [ProductController::class, 'createNewProductType'])
                        ->name('product_type.create');

                        # Category
                        Route::get("/all-categories", [ProductController::class,"categoriesView"]);
                        Route::get("/attributes", [ProductController::class,"attributesView"]);

                    }
                );

                Route::prefix('blog')->group(function ()
                    {

                        Route::get( "/posts-list", [BlogController::class,"postsList"]);
                        Route::get( "/create-post", [BlogController::class,"create"]);
                        Route::post( "/create-post", [BlogController::class,"store"]);
                        Route::post( "/delete-post", [BlogController::class,"delete"]);
                        Route::post('categories/store', [BlogController::class, 'createNewGenre'])
                        ->name('genre.create');
                        Route::get( "/edit-post/{post_id}", [BlogController::class,"edit"])
                        ->name('post.edit');
                        Route::patch( "/update-post/{post_id}", [BlogController::class,"update"])
                        ->name("posts.update");
                        Route::delete('/comments/bulk-delete/{post_id}', [BlogController::class, 'bulkDeleteComments'])
                        ->name('comments.bulkDelete');

                    }
                );

                Route::prefix('users')->group(function ()
                    {

                        Route::get( "/", [UsersController::class,"index"],)->name("users");
                        Route::get( "/create-user", [UsersController::class,"create"]);
                        Route::post( "/create-user", [UsersController::class,"store"]);

                    }
                );

                Route::prefix('finance-payment')->group(function ()
                    {
                        # Wallet
                        Route::get( "/users-wallets", [FinanceAndPaymentController::class,"walletsView"]);
                        Route::get("/users-wallets/{wallet_id}", [FinanceAndPaymentController::class, "walletHistoryView"])
                        ->name("wallet.history");
                        Route::patch('/wallet/{wallet_id}/toggle-status', [FinanceAndPaymentController::class, 'toggleStatus'])
                        ->name('wallet.toggle.status');
                        Route::patch('/users-wallets/{wallet_id}/add-history', [FinanceAndPaymentController::class, 'addHistory'])
                        ->name('wallet.add.history');

                        # Orders
                        Route::get( "/users-orders", [FinanceAndPaymentController::class,"ordersView"]);

                        # Payments
                        Route::get( "/users-payments", [FinanceAndPaymentController::class,"paymentsView"]);

                    }
                );
            }
        );

    }  
);