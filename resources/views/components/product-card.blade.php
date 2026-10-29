@props(['product'])

{{-- Los data-* los lee scripts.js para llenar el modal de producto. --}}
<article @class(['product-card', 'is-featured' => $product->is_featured])
         data-name="{{ $product->name }}"
         data-price="{{ number_format($product->price, 2) }}$"
         data-description="{{ $product->description }}"
         data-image="{{ asset($product->image_path) }}">

    <div class="product-thumb">
        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
    </div>

    <div class="caption product-card-caption">{{ $product->name }}</div>
</article>
