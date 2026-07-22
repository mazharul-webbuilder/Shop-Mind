<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\View::composer('frontend.layout.master', function ($view) {
            $cartService = app(\App\Services\Frontend\CartService::class);
            $view->with('cartCount', $cartService->getCartCount());
        });
    }
}
