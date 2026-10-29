@extends('layouts.app')

@section('title', 'Panel de administración')

@section('content')
<main class="admin">
    <div class="admin-inner">
        <h1 class="admin-title">Panel de administración</h1>

        <!-- ========= CREAR CATEGORÍA ========== -->
        <div class="admin-block admin-block-category">
            <h2>Crear categoría</h2>

            @session('category_status')
                <p class="admin-success">{{ $value }}</p>
            @endsession

            @if ($errors->category->any())
                <p class="admin-error">{{ $errors->category->first() }}</p>
            @endif

            <form action="{{ route('admin.categories.store') }}" method="post" class="admin-form">
                @csrf
                <label>
                    <span>Nombre</span>
                    <input type="text" name="name" required>
                </label>

                <label>
                    <span>Slug (opcional)</span>
                    <input type="text" name="slug" placeholder="Opcional">
                </label>

                <label>
                    <span>Descripción</span>
                    <textarea name="description" rows="3"></textarea>
                </label>

                <label>
                    <span>Orden de aparición</span>
                    <input type="number" name="display_order" value="0">
                </label>

                <label class="chk-inline">
                    <input type="checkbox" name="is_active" checked>
                    <span>Activa</span>
                </label>

                <button type="submit" class="btn-submit">Guardar categoría</button>
            </form>
        </div>

        <!-- ========== CREAR PRODUCTO ========== -->
        <div class="admin-block admin-block-product-create">
            <h2>Crear producto</h2>

            @session('product_status')
                <p class="admin-success">{{ $value }}</p>
            @endsession

            @if ($errors->product->any())
                <p class="admin-error">{{ $errors->product->first() }}</p>
            @endif

            @if ($categories->isEmpty())
                <p class="admin-warning">
                    No hay categorías activas. Crea al menos una categoría antes de agregar productos.
                </p>
            @else
                <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data" class="admin-form">
                    @csrf
                    <label>
                        <span>Nombre</span>
                        <input type="text" name="name" required>
                    </label>

                    <label>
                        <span>Descripción</span>
                        <textarea name="description" rows="3"></textarea>
                    </label>

                    <label>
                        <span>Precio</span>
                        <input type="number" name="price" step="0.01" min="0" required>
                    </label>

                    <label>
                        <span>Categoría</span>
                        <select name="category_id" required>
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        <span>Imagen</span>
                        <input type="file" name="image" accept="image/*" required>
                    </label>

                    <label class="chk-inline">
                        <input type="checkbox" name="is_featured">
                        <span>Producto destacado</span>
                    </label>

                    <label class="chk-inline">
                        <input type="checkbox" name="is_active" checked>
                        <span>Activo</span>
                    </label>

                    <button type="submit" class="btn-submit">Guardar producto</button>
                </form>
            @endif
        </div>

        <!-- ========== MODIFICAR / ELIMINAR PRODUCTO ========== -->
        <div class="admin-block admin-block-product-edit">
            <h2>Modificar / eliminar producto</h2>

            @session('edit_status')
                <p class="admin-success">{{ $value }}</p>
            @endsession

            @if ($errors->edit->any())
                <p class="admin-error">{{ $errors->edit->first() }}</p>
            @endif

            <form method="get" class="admin-form admin-form-id">
                <label>
                    <span>ID del producto</span>
                    <input type="number" name="edit_id" value="{{ $editId ?: '' }}" min="1">
                </label>
                <button type="submit" class="btn-submit">Cargar producto</button>
            </form>

            @if ($editId > 0 && ! $productToEdit)
                <p class="admin-warning">No se encontró ningún producto con ID {{ $editId }}.</p>
            @endif

            @if ($productToEdit)
                <form action="{{ route('admin.products.update', $productToEdit) }}" method="post" enctype="multipart/form-data" class="admin-form">
                    @csrf
                    @method('PUT')

                    <label>
                        <span>Nombre</span>
                        <input type="text" name="name" value="{{ $productToEdit->name }}" required>
                    </label>

                    <label>
                        <span>Descripción</span>
                        <textarea name="description" rows="3">{{ $productToEdit->description }}</textarea>
                    </label>

                    <label>
                        <span>Precio</span>
                        <input type="number" name="price" step="0.01" min="0" value="{{ $productToEdit->price }}" required>
                    </label>

                    <label>
                        <span>Categoría</span>
                        <select name="category_id" required>
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" @selected($productToEdit->category_id === $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        <span>Imagen actual</span>
                        <small>{{ $productToEdit->image_path }}</small>
                    </label>

                    <label>
                        <span>Nueva imagen (opcional)</span>
                        <input type="file" name="image" accept="image/*">
                    </label>

                    <label class="chk-inline">
                        <input type="checkbox" name="is_featured" @checked($productToEdit->is_featured)>
                        <span>Producto destacado</span>
                    </label>

                    <label class="chk-inline">
                        <input type="checkbox" name="is_active" @checked($productToEdit->is_active)>
                        <span>Activo</span>
                    </label>

                    <div class="admin-actions-row">
                        <button type="submit" class="btn-submit">Guardar cambios</button>
                        <button type="submit" form="delete-product" class="btn-danger"
                                onclick="return confirm('¿Seguro que deseas eliminar este producto?');">
                            Eliminar producto
                        </button>
                    </div>
                </form>

                <form id="delete-product" action="{{ route('admin.products.destroy', $productToEdit) }}" method="post">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
</main>
@endsection
