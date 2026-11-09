<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Carrito guardado en la sesión como [product_id => cantidad].
 * shortcut: se pierde al cerrar sesión; pasarlo a una tabla `cart_items` si debe sobrevivir entre dispositivos.
 */
class Cart
{
    private const KEY = 'cart';

    public const MAX_QUANTITY = 99;

    public function add(Product $product, int $quantity): void
    {
        $this->set($product, ($this->all()[$product->id] ?? 0) + $quantity);
    }

    public function set(Product $product, int $quantity): void
    {
        session()->put(self::KEY.'.'.$product->id, min($quantity, self::MAX_QUANTITY));
    }

    public function remove(Product $product): void
    {
        session()->forget(self::KEY.'.'.$product->id);
    }

    public function clear(): void
    {
        session()->forget(self::KEY);
    }

    public function count(): int
    {
        return array_sum($this->all());
    }

    /**
     * Productos del carrito con su cantidad y subtotal. Los precios salen de la BD, nunca del navegador;
     * si un producto se desactivó desde que se agregó, ya no aparece.
     *
     * @return Collection<int, object{product: Product, quantity: int, subtotal: float}>
     */
    public function items(): Collection
    {
        $cart = $this->all();

        return Product::active()->whereIn('id', array_keys($cart))->get()
            ->map(fn (Product $product) => (object) [
                'product' => $product,
                'quantity' => $cart[$product->id],
                'subtotal' => $product->price * $cart[$product->id],
            ]);
    }

    /** @return array<int, int> */
    private function all(): array
    {
        return session(self::KEY, []);
    }
}
