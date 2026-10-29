<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 50, 500),
            'image_path' => 'Recursos/producto1_1765211937.png',
            'is_featured' => false,
            'is_active' => true,
            'category_id' => Category::factory(),
        ];
    }
}
