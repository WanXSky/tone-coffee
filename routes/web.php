<?php
 
// ============================================================
// FILE: routes/web.php
// ============================================================
 
use App\Http\Controllers\Admin\CourierController as AdminCourierController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShippingController;
use Illuminate\Support\Facades\Route;
 
// ─── Halaman publik ──────────────────────────────────────────
Route::get('/', [MenuController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');
 
// ─── Autentikasi (Laravel Breeze) ────────────────────────────
require __DIR__ . '/auth.php';
 
// ─── Customer (harus login) ──────────────────────────────────
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
 
    // Order
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
 
    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/upload', [PaymentController::class, 'upload'])->name('payment.upload');

    // Live update status order
    Route::get('/order/{order}/status', [OrderController::class, 'checkStatus'])->name('order.status');
    Route::post('/calculate-shipping', [ShippingController::class, 'calculate'])->name('shipping.calculate');
});
 
// ─── Admin panel ─────────────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
 
        // Menu management
        Route::get('/menus/toggle/{menu}', [AdminMenuController::class, 'toggleAvailable'])->name('menus.toggle');
        Route::resource('menus', AdminMenuController::class);
 
        // Order management
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::patch('/orders/{order}/courier', [AdminOrderController::class, 'assignCourier'])->name('orders.courier');
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
 
        // Courier management
        Route::get('/couriers/{courier}/toggle', [AdminCourierController::class, 'toggleStatus'])->name('couriers.toggle');
        Route::resource('couriers', AdminCourierController::class);
 
        // Payment management
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/{payment}/confirm', [AdminPaymentController::class, 'confirm'])->name('payments.confirm');
        Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    });