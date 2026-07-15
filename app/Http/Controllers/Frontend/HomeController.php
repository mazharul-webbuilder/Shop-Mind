<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\HomeService;

class HomeController extends Controller
{
    public function __construct(private readonly HomeService $homeService)
    {
    }

    //
    public function index()
    {
        [$newArrivals, $featuredProducts] = $this->homeService->getHomePageData();
        return view('frontend.home.index', compact('featuredProducts', 'newArrivals'));
    }
}
