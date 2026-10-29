<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Rosas',
            'description' => 'Regalo floral',
            'price' => 200,
            'image_path' => 'Recursos/Flores_1765211859.png',
            'category_id' => Category::firstWhere('slug', 'detalles')->id,
        ]);

        Product::create([
            'name' => 'Taza',
            'description' => 'Diseño de taza personalizado',
            'price' => 100,
            'image_path' => 'Recursos/producto1_1765211937.png',
            'category_id' => Category::firstWhere('slug', 'tazas')->id,
        ]);
    }
}
