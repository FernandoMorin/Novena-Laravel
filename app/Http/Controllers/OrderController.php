<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()->orders()->withCount('items')->latest()->paginate(10);

        return view('orders.index', ['orders' => $orders]);
    }

    public function show(Order $order): View
    {
        return view('orders.show', ['order' => $order->load('items.product')]);
    }

    /** Convierte el carrito en un pedido. */
    public function store(Request $request, Cart $cart): RedirectResponse
    {
        $items = $cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Tu carrito está vacío.');
        }

        // Pedido y renglones se guardan juntos: si algo falla no queda un pedido a medias.
        $order = DB::transaction(function () use ($request, $items) {
            $order = $request->user()->orders()->create(['total' => $items->sum('subtotal')]);

            $order->items()->createMany($items->map(fn ($item) => [
                'product_id' => $item->product->id,
                'product_name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ])->all());

            return $order;
        });

        $cart->clear();

        return redirect()->route('orders.show', $order)->with('status', '¡Gracias! Tu pedido #'.$order->id.' se registró.');
    }
}
