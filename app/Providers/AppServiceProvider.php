<?php

namespace App\Providers;

use App\Support\Attribute\ProductAttributeService;
use App\Support\Storage\Contracts\StorageInterface;
use App\Support\Storage\SessionStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductAttributeService::class, function ($app) {
            return new ProductAttributeService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(StorageInterface::class, function ($app) {
            return new SessionStorage('cart');
        });
    }
}
