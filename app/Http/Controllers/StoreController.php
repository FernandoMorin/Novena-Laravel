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
        $selectedCat = $request->integer('cat');

        $products = Product::where('is_active', true)
            ->when($selectedCat > 0, fn ($query) => $query->where('category_id', $selectedCat))
            ->latest('id')
            ->get();

        return view('store', [
            'categories' => Category::active()->get(),
            'products' => $products,
            'selectedCat' => $selectedCat,
        ]);
    }
}
