<x-page :title="'Pedido #'.$order->id">
    <div class="d-flex flex-wrap gap-3 align-items-center mb-4" data-reveal="left">
        <x-order-status :status="$order->status" />
        <span class="text-body-secondary"><i class="bi bi-calendar3 me-1"></i>{{ $order->created_at->format('d/m/Y H:i') }}</span>
        <a href="{{ route('orders.index') }}" class="ms-auto link-dark"><i class="bi bi-arrow-left"></i> Mis pedidos</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-reveal="up">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                {{-- El producto pudo haberse borrado; el nombre guardado en el pedido siempre está. --}}
                                @if ($item->product?->is_active)
                                    <a href="{{ route('products.show', $item->product) }}" class="link-dark">{{ $item->product_name }}</a>
                                @else
                                    {{ $item->product_name }}
                                @endif
                            </td>
                            <td><x-price :amount="$item->price" /></td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-end"><x-price :amount="$item->price * $item->quantity" /></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th class="text-end"><x-price :amount="$order->total" class="fs-5 text-brand" /></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-page>
