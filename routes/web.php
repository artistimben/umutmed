<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminPanelController;
use App\Models\Order;

// Home & Products
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/urun/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/kategori/{slug}', [ProductController::class, 'category'])->name('products.category');
Route::get('/ara', [ProductController::class, 'search'])->name('products.search');

// Cart
Route::get('/sepet', [CartController::class, 'index'])->name('cart.index');
Route::post('/sepet/ekle/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/sepet/guncelle/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/sepet/sil/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout
Route::get('/odeme', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/odeme', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/tesekkurler/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

// Wishlist
Route::get('/favorilerim', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/favorilerim/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

// Reviews
Route::post('/urun/{id}/yorum-yap', [ReviewController::class, 'store'])->name('reviews.store');

// Contact
Route::get('/iletisim', [ContactController::class, 'index'])->name('contact.index');
Route::post('/iletisim', [ContactController::class, 'store'])->name('contact.store');

// Admin Panel & Profile
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin-panel', [AdminPanelController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/products', [AdminPanelController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/create', [AdminPanelController::class, 'createProduct'])->name('admin.products.create');
    
    Route::get('/admin/categories', [AdminPanelController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/categories/create', [AdminPanelController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/admin/categories', [AdminPanelController::class, 'storeCategory'])->name('admin.categories.store');

    Route::get('/admin/current-accounts', [AdminPanelController::class, 'currentAccounts'])->name('admin.current_accounts');
    Route::post('/admin/sync-trendyol', [AdminPanelController::class, 'syncTrendyol'])->name('admin.sync-trendyol');

    Route::get('/admin/settings', [AdminPanelController::class, 'storeSettings'])->name('admin.settings');
    Route::post('/admin/settings', [AdminPanelController::class, 'updateSettings'])->name('admin.settings.update');

    // Rename legacy dashboard name for compatibility if needed
    Route::get('/dashboard', [AdminPanelController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
