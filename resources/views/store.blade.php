@extends('layouts.app')

@section('title', 'Novena Studio · Tienda')

@section('content')
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
                @forelse ($products as $p)
                    <article @class(['product-card', 'is-featured' => $p->is_featured])
                             data-name="{{ $p->name }}"
                             data-price="{{ number_format($p->price, 2) }}$"
                             data-description="{{ $p->description }}"
                             data-image="{{ asset($p->image_path) }}">

                        <div class="product-thumb">
                            <img src="{{ asset($p->image_path) }}" alt="{{ $p->name }}">
                        </div>

                        <div class="caption product-card-caption">{{ $p->name }}</div>
                    </article>
                @empty
                    <p class="products-empty">No hay productos en esta categoría todavía.</p>
                @endforelse
            </div>
        </section>

        <div class="product-modal" id="product-modal" aria-hidden="true">
            <div class="product-modal-backdrop"></div>

            <div class="product-modal-dialog" role="dialog" aria-modal="true">
                <button class="product-modal-close" aria-label="Cerrar">✕</button>

                <div class="product-modal-body">
                    <div class="product-modal-image">
                        <img src="" alt="" id="modal-product-image">
                    </div>
                    <div class="product-modal-info">
                        <h2 id="modal-product-name"></h2>
                        <p class="modal-product-price" id="modal-product-price"></p>
                        <p class="modal-product-description" id="modal-product-description"></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
