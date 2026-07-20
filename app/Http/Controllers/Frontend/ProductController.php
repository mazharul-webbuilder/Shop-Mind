<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\ProductService;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function show(string $slug)
    {
        $product = $this->productService->getProductBySlug($slug);
        return view('frontend.product.show', compact('product'));
    }
}
