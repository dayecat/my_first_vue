<?php

use App\Http\Controllers\productController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/', function () {
        return Inertia::render('Backend/Dashboard');
    })->name('dashboard');

    Route::get('/product', [productController::class, 'index'])->name('product.list');
    Route::get('/product/create', [productController::class, 'product_create'])->name('product.create');
    Route::post('/product/store', [productController::class, 'product_store'])->name('product.store');
    Route::delete('/product/delete', [productController::class, 'product_delete'])->name('product.delete');
    Route::get('/product/edit{id}', [productController::class, 'product_edit'])->name('product.edit');
    Route::put('/product/update', [productController::class, 'product_update'])->name('product.update');
});
