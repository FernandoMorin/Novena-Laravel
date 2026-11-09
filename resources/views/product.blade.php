<x-page :title="$product->name" heading="">
    <nav aria-label="breadcrumb" data-reveal="left">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('store') }}">Productos</a></li>
            @if ($product->category)
                <li class="breadcrumb-item"><a href="{{ route('store', ['cat' => $product->category_id]) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4 g-lg-5 align-items-start">
        <div class="col-md-6" data-reveal="left">
            <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="img-fluid rounded-4 shadow product-detail-img">
        </div>

        <div class="col-md-6" data-reveal="right">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    @if ($product->is_featured)
                        <span class="badge text-bg-warning mb-2"><i class="bi bi-star-fill"></i> Destacado</span>
                    @endif
                    <h1 class="h2 product-detail-name">{{ $product->name }}</h1>
                    <x-price :amount="$product->price" class="d-block fs-3 fw-bold text-brand mb-3" />
                    <p class="text-body-secondary">{{ $product->description }}</p>

                    <form method="post" action="{{ route('cart.store', $product) }}" class="row g-2 align-items-end mt-3">
                        @csrf
                        <div class="col-4 col-sm-3">
                            <label for="quantity" class="form-label small">Cantidad</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ \App\Services\Cart::MAX_QUANTITY }}" class="form-control">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-brand w-100"><i class="bi bi-bag-plus me-1"></i> Agregar al carrito</button>
                        </div>
                    </form>
                    @error('quantity')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    @if ($related->isNotEmpty())
        <section class="mt-5">
            <h2 class="store-section-title" data-reveal="left">También te puede gustar</h2>
            <div class="row g-4">
                @foreach ($related as $item)
                    <div class="col-6 col-md-3">
                        <x-product-card :product="$item" />
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</x-page>
