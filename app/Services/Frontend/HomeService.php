<?php

namespace App\Services\Frontend;

use App\Models\Product;

class HomeService
{

    public function getHomePageData()
    {
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $newArrivals = Product::where('is_active', true)
            ->where('is_new', true)
            ->latest()
            ->take(8)
            ->get();

        return [$newArrivals, $featuredProducts];
    }
}
