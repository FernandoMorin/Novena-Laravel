@props(['product'])

<a href="{{ route('products.show', $product) }}"
   {{ $attributes->class(['product-card', 'is-featured' => $product->is_featured]) }} data-reveal="up">
    <div class="product-thumb">
        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" loading="lazy">
    </div>

    <div class="caption product-card-caption">
        <span class="product-card-name">{{ $product->name }}</span>
        <x-price :amount="$product->price" class="product-card-price" />
    </div>
</a>
