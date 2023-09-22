<?php

use App\Http\Controllers\FrontController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontController::class, 'home'])->name('home');


Route::middleware(['auth', 'verified'])->post('/addCarts', [FrontController::class, 'addCart'])->name('product.addCart');


Route::middleware(['auth','verified'])->get('/addCarts', [FrontController::class, 'addCart'])->name('product.addCart');
