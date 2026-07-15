<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'image' => fake()->imageUrl(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'description' => fake()->paragraph(),
            'is_active' => fake()->boolean(),
            'is_featured' => fake()->boolean(),
            'is_trending' => fake()->boolean(),
            'is_new' => fake()->boolean(),
            'is_sale' => fake()->boolean(),
            'quantity' => fake()->numberBetween(0, 100),
            'sold' => fake()->numberBetween(0, 100),
            'views' => fake()->numberBetween(0, 100),
            'rating' => fake()->numberBetween(0, 5),
            'rating_count' => fake()->numberBetween(0, 100),
            'order' => fake()->numberBetween(0, 100),
        ];
    }
}
