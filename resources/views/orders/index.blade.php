<x-page title="Mis pedidos">
    @if ($orders->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 text-center p-5" data-reveal="up">
            <i class="bi bi-receipt display-4 text-body-tertiary"></i>
            <p class="lead mt-3">Todavía no has hecho ningún pedido.</p>
            <div><a href="{{ route('store') }}" class="btn btn-brand">Ir a la tienda</a></div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-reveal="up">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Fecha</th>
                            <th>Artículos</th>
                            <th>Estado</th>
                            <th class="text-end">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="fw-semibold">#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $order->items_count }}</td>
                                <td><x-order-status :status="$order->status" /></td>
                                <td class="text-end"><x-price :amount="$order->total" /></td>
                                <td class="text-end"><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-dark">Ver</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">{{ $orders->links() }}</div>
    @endif
</x-page>
