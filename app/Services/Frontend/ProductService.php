<?php

namespace App\Services\Frontend;

use App\Models\Product;

class ProductService
{
    public function getProductBySlug(string $slug)
    {
        return Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }
}
