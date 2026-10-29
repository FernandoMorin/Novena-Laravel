<x-layout title="Panel de administración">
    <main class="admin">
        <div class="admin-inner">
            <h1 class="admin-title">Panel de administración</h1>

            <!-- ========= CREAR CATEGORÍA ========== -->
            <x-admin.block title="Crear categoría" status="category_status" bag="category" class="admin-block-category">
                <form action="{{ route('admin.categories.store') }}" method="post" class="admin-form">
                    @csrf
                    <x-form.field label="Nombre" name="name" required />
                    <x-form.field label="Slug (opcional)" name="slug" placeholder="Opcional" />
                    <x-form.field label="Descripción" type="textarea" name="description" />
                    <x-form.field label="Orden de aparición" type="number" name="display_order" value="0" />
                    <x-form.checkbox label="Activa" name="is_active" checked />

                    <button type="submit" class="btn-submit">Guardar categoría</button>
                </form>
            </x-admin.block>

            <!-- ========== CREAR PRODUCTO ========== -->
            <x-admin.block title="Crear producto" status="product_status" bag="product" class="admin-block-product-create">
                @if ($categories->isEmpty())
                    <p class="admin-warning">
                        No hay categorías activas. Crea al menos una categoría antes de agregar productos.
                    </p>
                @else
                    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data" class="admin-form">
                        @csrf
                        <x-admin.product-fields :categories="$categories" />

                        <button type="submit" class="btn-submit">Guardar producto</button>
                    </form>
                @endif
            </x-admin.block>

            <!-- ========== MODIFICAR / ELIMINAR PRODUCTO ========== -->
            <x-admin.block title="Modificar / eliminar producto" status="edit_status" bag="edit" class="admin-block-product-edit">
                <form method="get" class="admin-form admin-form-id">
                    <x-form.field label="ID del producto" type="number" name="edit_id" :value="$editId ?: null" min="1" />
                    <button type="submit" class="btn-submit">Cargar producto</button>
                </form>

                @if ($editId > 0 && ! $productToEdit)
                    <p class="admin-warning">No se encontró ningún producto con ID {{ $editId }}.</p>
                @endif

                @if ($productToEdit)
                    <form action="{{ route('admin.products.update', $productToEdit) }}" method="post" enctype="multipart/form-data" class="admin-form">
                        @csrf
                        @method('PUT')
                        <x-admin.product-fields :categories="$categories" :product="$productToEdit" />

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
            </x-admin.block>
        </div>
    </main>
</x-layout>
