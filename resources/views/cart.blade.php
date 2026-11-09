<x-page title="Carrito" heading="Tu carrito">
    @if ($items->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 text-center p-5" data-reveal="up">
            <i class="bi bi-bag display-4 text-body-tertiary"></i>
            <p class="lead mt-3">Tu carrito está vacío.</p>
            <div><a href="{{ route('store') }}" class="btn btn-brand">Ver productos</a></div>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8" data-reveal="left">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th colspan="2">Producto</th>
                                    <th>Precio</th>
                                    <th style="width: 9rem">Cantidad</th>
                                    <th class="text-end">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td style="width: 4.5rem">
                                            <img src="{{ asset($item->product->image_path) }}" alt="" class="rounded cart-thumb">
                                        </td>
                                        <td><a href="{{ route('products.show', $item->product) }}" class="link-dark fw-semibold text-decoration-none">{{ $item->product->name }}</a></td>
                                        <td><x-price :amount="$item->product->price" /></td>
                                        <td>
                                            <form method="post" action="{{ route('cart.update', $item->product) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ \App\Services\Cart::MAX_QUANTITY }}"
                                                       class="form-control form-control-sm" aria-label="Cantidad de {{ $item->product->name }}" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="text-end fw-semibold"><x-price :amount="$item->subtotal" /></td>
                                        <td class="text-end">
                                            <form method="post" action="{{ route('cart.destroy', $item->product) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Quitar {{ $item->product->name }}"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @error('quantity')
                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-lg-4" data-reveal="right">
                <div class="card border-0 shadow-sm rounded-4 sticky-lg-top cart-summary">
                    <div class="card-body p-4">
                        <h2 class="h5">Resumen</h2>
                        <div class="d-flex justify-content-between my-3">
                            <span>Total</span>
                            <x-price :amount="$total" class="fs-4 fw-bold text-brand" />
                        </div>
                        @auth
                            <form method="post" action="{{ route('orders.store') }}">
                                @csrf
                                <button type="submit" class="btn btn-brand w-100 btn-lg">Realizar pedido</button>
                            </form>
                        @else
                            <button type="button" class="btn btn-brand w-100 btn-lg" data-open-login>Inicia sesión para pedir</button>
                        @endauth
                        <a href="{{ route('store') }}" class="btn btn-link w-100 mt-2 text-dark">Seguir comprando</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-page>
