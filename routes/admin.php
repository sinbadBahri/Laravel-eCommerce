<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
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
                        Route::get( "/edit-product-line/{product_line_id}", [ProductController::class,"editProductLine"])
                        ->name('product_line.edit');
                        Route::put( "/update-product-line/{product_line_id}", [ProductController::class,"updateProductLine"])
                        ->name("product_line.update");
                        Route::get("/add-product", [ProductController::class,"addProductForm"]);
                        Route::post("/add-product", [ProductController::class,"storeProduct"]);
                        Route::post('/add-brand', [ProductController::class, 'createNewBrand'])
                        ->name('brand.create');
                        Route::post('/add-product-type', [ProductController::class, 'createNewProductType'])
                        ->name('product_type.create');

                        # Category
                        Route::get("/all-categories", [CategoryController::class,"index"]);
                        Route::post("/all-categories/create-new-category", [CategoryController::class,"store"])
                        ->name('category.create');
                        Route::post('/all-categories/delete-category', [CategoryController::class, "delete"])
                        ->name('category.delete');
                        Route::get( "/edit-category/{category_id}", [CategoryController::class,"edit"])
                        ->name('category.edit');
                        Route::put( "/update-category/{category_id}", [CategoryController::class,"update"])
                        ->name("category.update");

                        # Attribute
                        Route::get("/attributes", [AttributeController::class,"index"]);
                        Route::post("/delete-product-attribute", [AttributeController::class, "delete"])
                        ->name('attribute.delete');
                        Route::post("/create-new-attribute", [AttributeController::class, "store"])
                        ->name('attribute.create');

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

                        # Discounts
                        Route::post("/create-new-discount", [FinanceAndPaymentController::class, "storeDiscount"])
                        ->name('discount.create');

                    }
                );
            }
        );

    }
);
