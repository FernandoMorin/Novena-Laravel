<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/productos', [StoreController::class, 'index'])->name('store');
Route::get('/productos/{product}', [StoreController::class, 'show'])->name('products.show');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// El carrito funciona sin sesión; para pedir sí hay que iniciarla.
Route::controller(CartController::class)->prefix('carrito')->name('cart.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/{product}', 'store')->name('store');
    Route::patch('/{product}', 'update')->name('update');
    Route::delete('/{product}', 'destroy')->name('destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/mis-pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/mis-pedidos/{order}', [OrderController::class, 'show'])->name('orders.show')->can('view', 'order');

    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/perfil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::middleware('can:admin')->prefix('admin')->name('admin.')->controller(AdminController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/categorias', 'storeCategory')->name('categories.store');
    Route::post('/productos', 'storeProduct')->name('products.store');
    Route::put('/productos/{product}', 'updateProduct')->name('products.update');
    Route::delete('/productos/{product}', 'destroyProduct')->name('products.destroy');
});
