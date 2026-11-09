<x-layout title="Novena Studio · Tienda">
    <main class="store" id="productos">
        <div class="store-inner">

            {{-- ===== BÚSQUEDA + CATEGORÍA ===== --}}
            <form method="get" class="store-toolbar row g-2 align-items-center" role="search">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="input-group search-box">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="search" name="q" value="{{ $search }}" class="form-control" placeholder="Buscar productos..." aria-label="Buscar productos">
                    </div>
                </div>
                <div class="col-auto category-filter">
                    <label>
                        <span>CATEGORÍA</span>
                        <select name="cat" onchange="this.form.submit()">
                            <option value="">Todas las categorías</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" @selected($selectedCat === $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-brand">Buscar</button>
                    @if ($search !== '' || $selectedCat > 0)
                        <a href="{{ route('store') }}" class="btn btn-link text-dark">Limpiar</a>
                    @endif
                </div>
            </form>

            {{-- ===== DESTACADOS ===== --}}
            @if ($featured->isNotEmpty())
                <section class="featured mb-5">
                    <h2 class="store-section-title" data-reveal="left"><i class="bi bi-star-fill"></i> Destacados</h2>
                    <div class="row g-4">
                        @foreach ($featured as $product)
                            <div class="col-6 col-md-4 col-lg-3">
                                <x-product-card :product="$product" class="product-card-lg" />
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- ===== CATÁLOGO ===== --}}
            <section>
                <h2 class="store-section-title" data-reveal="left">
                    @if ($search !== '')
                        Resultados para «{{ $search }}»
                    @else
                        Todos los productos
                    @endif
                    <small class="text-body-secondary fs-6">({{ $products->total() }})</small>
                </h2>

                <div class="products-grid">
                    @forelse ($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <p class="products-empty">No encontramos productos con esos filtros.</p>
                    @endforelse
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </section>
        </div>
    </main>
</x-layout>
