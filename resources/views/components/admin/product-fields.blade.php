{{-- Campos compartidos por "Crear producto" (sin $product) y "Modificar producto" (con $product). --}}
@props(['categories', 'product' => null])

<x-form.field label="Nombre" name="name" :value="$product?->name" required />
<x-form.field label="Descripción" type="textarea" name="description" :value="$product?->description" />
<x-form.field label="Precio" type="number" name="price" step="0.01" min="0" :value="$product?->price" required />

<label>
    <span>Categoría</span>
    <select name="category_id" required>
        <option value="">Selecciona una categoría</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @selected($product?->category_id === $cat->id)>{{ $cat->name }}</option>
        @endforeach
    </select>
</label>

@if ($product)
    <label>
        <span>Imagen actual</span>
        <small>{{ $product->image_path }}</small>
    </label>
    <x-form.field label="Nueva imagen (opcional)" type="file" name="image" accept="image/*" />
@else
    <x-form.field label="Imagen" type="file" name="image" accept="image/*" required />
@endif

<x-form.checkbox label="Producto destacado" name="is_featured" :checked="$product?->is_featured" />
<x-form.checkbox label="Activo" name="is_active" :checked="$product?->is_active ?? true" />
