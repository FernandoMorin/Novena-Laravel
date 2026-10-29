<x-layout title="Novena Studio · Tienda">
    <main class="store" id="productos">
        <div class="store-inner">

            <section class="store-products-wrapper">

                <div class="store-toolbar">
                    <form method="get" class="category-filter">
                        <label>
                            <span>CATEGORÍA</span>
                            <select name="cat" onchange="this.form.submit()">
                                <option value="">Todas las categorías</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected($selectedCat === $cat->id)>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </form>
                </div>

                <div class="products-grid">
                    @forelse ($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <p class="products-empty">No hay productos en esta categoría todavía.</p>
                    @endforelse
                </div>
            </section>

            <x-product-modal />

        </div>
    </main>
</x-layout>
