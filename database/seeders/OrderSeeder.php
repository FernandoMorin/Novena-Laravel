<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

/** Pedidos de ejemplo para que "Mis pedidos" del usuario demo no salga vacío. */
class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstWhere('email', 'user@novena.com');

        // [estado, [nombre de producto => cantidad]]
        $orders = [
            ['entregado', ['Rosas' => 1, 'Tarjeta ilustrada' => 1]],
            ['enviado', ['Taza mágica' => 2]],
            ['pendiente', ['Caja de regalo' => 1, 'Vaso térmico' => 1]],
        ];

        foreach ($orders as $daysAgo => [$status, $lines]) {
            $products = Product::whereIn('name', array_keys($lines))->get();

            $order = $user->orders()->create([
                'status' => $status,
                'total' => $products->sum(fn (Product $product) => $product->price * $lines[$product->name]),
            ]);

            $order->items()->createMany($products->map(fn (Product $product) => [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $lines[$product->name],
            ])->all());

            // El más viejo primero, para que las fechas se vean realistas.
            $order->forceFill(['created_at' => now()->subDays((count($orders) - $daysAgo) * 5)])->save();
        }
    }
}
