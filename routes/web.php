<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/myprofile', [MyProfileController::class, 'show'])->name('myprofile.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/checkout', [CartController::class, 'processCheckout'])->name('cart.checkout.process');
    Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
