<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('frontend.layout.master', function ($view) {
            $cartService = app(\App\Services\Frontend\CartService::class);
            $view->with('cartCount', $cartService->getCartCount());
        });
    }
}
