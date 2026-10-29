<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $editId = $request->integer('edit_id');

        return view('admin', [
            'categories' => Category::active()->get(),
            'editId' => $editId,
            'productToEdit' => $editId > 0 ? Product::find($editId) : null,
        ]);
    }

    public function storeCategory(CategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('admin.index')->with('category_status', 'Categoría creada correctamente.');
    }

    public function storeProduct(ProductRequest $request): RedirectResponse
    {
        Product::create([
            ...$request->safe()->except('image'),
            'image_path' => $this->saveImage($request->file('image')),
        ]);

        return redirect()->route('admin.index')->with('product_status', 'Producto creado correctamente.');
    }

    public function updateProduct(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->saveImage($request->file('image'));
        }

        $product->update($data);

        return redirect()->route('admin.index', ['edit_id' => $product->id])
            ->with('edit_status', 'Producto actualizado correctamente.');
    }

    public function destroyProduct(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.index')->with('edit_status', 'Producto eliminado correctamente.');
    }

    /** Guarda la imagen en public/uploads y regresa la ruta relativa que va en la BD. */
    private function saveImage(UploadedFile $file): string
    {
        $name = $file->hashName();
        $file->move(public_path('uploads'), $name);

        return 'uploads/'.$name;
    }
}
