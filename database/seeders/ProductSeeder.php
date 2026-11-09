<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private const TAZA = 'Recursos/producto1_1765211937.png';

    private const FLORES = 'Recursos/Flores_1765211859.png';

    public function run(): void
    {
        // [nombre, categoría, precio, destacado, imagen, descripción]
        $catalog = [
            ['Rosas', 'detalles', 200, true, self::FLORES, 'Regalo floral'],
            ['Taza', 'tazas', 100, false, self::TAZA, 'Diseño de taza personalizado'],
            ['Taza mágica', 'tazas', 180, true, self::TAZA, 'Revela tu diseño al servir una bebida caliente'],
            ['Taza pareja', 'tazas', 320, false, self::TAZA, 'Juego de dos tazas con diseños que se complementan'],
            ['Taza con nombre', 'tazas', 130, false, self::TAZA, 'Taza blanca con el nombre que tú elijas'],
            ['Vaso térmico', 'vasos', 250, true, self::TAZA, 'Mantiene tu bebida fría o caliente por horas'],
            ['Vaso de vidrio grabado', 'vasos', 160, false, self::TAZA, 'Vaso de vidrio con grabado personalizado'],
            ['Termo deportivo', 'vasos', 290, false, self::TAZA, 'Termo de acero inoxidable de 750 ml'],
            ['Caja de regalo', 'regalos', 450, true, self::FLORES, 'Caja con taza, flores y tarjeta personalizada'],
            ['Kit de cumpleaños', 'regalos', 520, false, self::FLORES, 'Todo lo necesario para sorprender en su día'],
            ['Ramo primavera', 'detalles', 350, false, self::FLORES, 'Ramo de flores de temporada'],
            ['Flores secas', 'detalles', 210, false, self::FLORES, 'Arreglo de flores secas que dura meses'],
            ['Tarjeta ilustrada', 'detalles', 60, false, self::FLORES, 'Tarjeta con ilustración original y mensaje'],
        ];

        $categories = Category::pluck('id', 'slug');

        foreach ($catalog as [$name, $category, $price, $featured, $image, $description]) {
            Product::create([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'image_path' => $image,
                'is_featured' => $featured,
                'category_id' => $categories[$category],
            ]);
        }
    }
}
