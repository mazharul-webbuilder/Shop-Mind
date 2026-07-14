<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    //
    public function index()
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

        return view('frontend.home.index', compact('featuredProducts', 'newArrivals'));
    }
}
