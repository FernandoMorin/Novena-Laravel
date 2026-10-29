<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
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

    public function storeCategory(Request $request): RedirectResponse
    {
        // Si no mandan slug se genera a partir del nombre, igual que en la versión PHP.
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('name', ''))]);

        $data = $request->validateWithBag('category', [
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'max:100', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
            'display_order' => ['nullable', 'integer'],
        ]);

        Category::create([
            ...$data,
            'display_order' => $data['display_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.index')->with('category_status', 'Categoría creada correctamente.');
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $data = $this->validateProduct($request, 'product', imageRequired: true);

        Product::create([
            ...$data,
            'image_path' => $this->saveImage($request->file('image')),
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.index')->with('product_status', 'Producto creado correctamente.');
    }

    public function updateProduct(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validateProduct($request, 'edit', imageRequired: false);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->saveImage($request->file('image'));
        }

        $product->update([
            ...$data,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.index', ['edit_id' => $product->id])
            ->with('edit_status', 'Producto actualizado correctamente.');
    }

    public function destroyProduct(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.index')->with('edit_status', 'Producto eliminado correctamente.');
    }

    private function validateProduct(Request $request, string $bag, bool $imageRequired): array
    {
        $data = $request->validateWithBag($bag, [
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'gt:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'max:4096'],
        ]);
        unset($data['image']);

        return $data;
    }

    /** Guarda la imagen en public/uploads y regresa la ruta relativa que va en la BD. */
    private function saveImage(UploadedFile $file): string
    {
        $name = $file->hashName();
        $file->move(public_path('uploads'), $name);

        return 'uploads/'.$name;
    }
}
