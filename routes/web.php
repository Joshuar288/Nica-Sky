<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipmentVerificationController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:user,admin'])
    ->name('home');

Route::get('/popular-products', [HomeController::class, 'popular'])
    ->middleware(['auth', 'verified', 'role:user,admin'])
    ->name('product.popular');

Route::get('/recommended-products', [HomeController::class, 'recommended'])
    ->middleware(['auth', 'verified', 'role:user,admin'])
    ->name('product.recommended');

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/shipments/{shipmentVerification}/evidence', [ShipmentVerificationController::class, 'evidence'])
        ->middleware('role:user,admin,auditor')
        ->name('shipments.evidence');

    Route::middleware('role:user,admin')->group(function () {
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/{product}', [ProductController::class, 'show'])->whereNumber('product')->name('product.show');
        Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');
        Route::get('/myprofile', [MyProfileController::class, 'show'])->name('myprofile.show');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::patch('/product/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::post('/cart/checkout', [CartController::class, 'processCheckout'])->name('cart.checkout.process');
        Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

        Route::post('/notifications/{notification}/shipment', [ShipmentVerificationController::class, 'store'])->name('shipments.store');
        Route::get('/premium', [PremiumController::class, 'show'])->name('premium.show');
        Route::get('/premium/checkout/{plan}', [PremiumController::class, 'checkout'])->name('premium.checkout');
        Route::post('/premium/purchase', [PremiumController::class, 'purchase'])->name('premium.purchase');
    });
});

Route::middleware(['auth', 'role:auditor,admin'])->prefix('auditor')->group(function () {
    Route::get('/shipments', [ShipmentVerificationController::class, 'index'])->name('auditor.shipments.index');
    Route::patch('/shipments/{shipmentVerification}', [ShipmentVerificationController::class, 'review'])->name('auditor.shipments.review');
});

Route::get('/dashboard', [DashboardController::class, 'redirect'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products.index');
    Route::patch('/admin/products/{product}/moderate', [AdminController::class, 'moderateProduct'])->name('admin.products.moderate');
    Route::delete('/admin/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

Route::middleware(['auth', 'role:auditor'])->group(function () {
    Route::get('/auditor/dashboard', [DashboardController::class, 'auditor'])->name('auditor.dashboard');
});

Route::middleware(['auth', 'role:user,admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
