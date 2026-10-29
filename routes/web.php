<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/productos', [StoreController::class, 'index'])->name('store');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('can:admin')->prefix('admin')->name('admin.')->controller(AdminController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/categorias', 'storeCategory')->name('categories.store');
    Route::post('/productos', 'storeProduct')->name('products.store');
    Route::put('/productos/{product}', 'updateProduct')->name('products.update');
    Route::delete('/productos/{product}', 'destroyProduct')->name('products.destroy');
});
