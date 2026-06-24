<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Redirect root to dashboard
Route::redirect('/', '/dashboard');

// Locale Switcher Route
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Shared reading index routes (both roles can read Lists)
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // Manajer-only routes: Full CRUD write access to Categories, Suppliers, Products
    Route::middleware('role:manajer')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['index', 'show']);
        Route::resource('suppliers', SupplierController::class)->except(['index', 'show']);
        Route::resource('products', ProductController::class)->except(['index', 'show']);
    });

    // Admin Gudang-only routes: Write access to Transactions (Create and Store logs)
    Route::middleware('role:admin_gudang')->group(function () {
        Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    });

    // Shared reading show routes (Wildcards defined last to prevent route collision with static /create)
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
});
