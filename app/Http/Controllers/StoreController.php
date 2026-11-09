<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q'));
        $selectedCat = $request->integer('cat');

        $products = Product::active()
            ->when($selectedCat > 0, fn ($query) => $query->where('category_id', $selectedCat))
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        // Los destacados solo se muestran en la portada de la tienda, no al buscar ni filtrar.
        $showFeatured = $search === '' && $selectedCat === 0 && $products->onFirstPage();

        return view('store', [
            'categories' => Category::active()->get(),
            'products' => $products,
            'featured' => $showFeatured ? Product::active()->where('is_featured', true)->latest('id')->take(4)->get() : collect(),
            'selectedCat' => $selectedCat,
            'search' => $search,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('product', [
            'product' => $product->load('category'),
            'related' => Product::active()
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product->id)
                ->inRandomOrder()
                ->take(4)
                ->get(),
        ]);
    }
}
