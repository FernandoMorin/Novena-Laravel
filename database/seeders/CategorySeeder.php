<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tazas', 'slug' => 'tazas', 'description' => 'Tazas personalizadas', 'display_order' => 1],
            ['name' => 'Vasos', 'slug' => 'vasos', 'description' => 'Vasos y termos', 'display_order' => 2],
            ['name' => 'Regalos', 'slug' => 'regalos', 'description' => 'Regalos para la gente', 'display_order' => 3],
            ['name' => 'Detalles', 'slug' => 'detalles', 'description' => 'Detalles de regalos', 'display_order' => 4],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
