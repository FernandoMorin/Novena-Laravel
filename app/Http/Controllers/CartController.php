<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Models\Product;
use App\Services\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Cart $cart): View
    {
        $items = $cart->items();

        return view('cart', ['items' => $items, 'total' => $items->sum('subtotal')]);
    }

    public function store(CartItemRequest $request, Product $product, Cart $cart): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $cart->add($product, $request->integer('quantity'));

        return back()->with('status', "«{$product->name}» se agregó al carrito.");
    }

    public function update(CartItemRequest $request, Product $product, Cart $cart): RedirectResponse
    {
        $cart->set($product, $request->integer('quantity'));

        return redirect()->route('cart.index');
    }

    public function destroy(Product $product, Cart $cart): RedirectResponse
    {
        $cart->remove($product);

        return redirect()->route('cart.index')->with('status', "«{$product->name}» se quitó del carrito.");
    }
}
