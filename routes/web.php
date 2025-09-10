<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonAnController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;    
use App\Http\Controllers\AdminController;    



//=========================== Web Routes ===========================
Route::get('login', [LoginController::class, 'index']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/monan', [MonAnController::class, 'index']);
Route::get('/monan/{maloai}', [MonAnController::class, 'showbyLoai'])->name('monan.theoloai');
Route::get('/images/monan/{filename}', [ImageController::class, 'show']);

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');


Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); // admin list
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my'); // đơn của user

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{id}', [AdminController::class, 'orderDetail'])->name('admin.orders.detail');
    Route::patch('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');
    Route::get('/monan', [AdminController::class, 'monan'])->name('admin.monan');
    Route::get('/loaimon', [AdminController::class, 'loaimon'])->name('admin.loaimon');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
});



Route::get('/_debug/logs', function () {
    // bảo vệ bằng header X-DEBUG-KEY
    $secret = env('DEBUG_KEY', null);
    if (!$secret || request()->header('X-DEBUG-KEY') !== $secret) {
        abort(404);
    }

    $path = storage_path('logs/laravel.log');
    if (!file_exists($path)) {
        return response('NO_LOG', 200);
    }
    return Response::download($path, 'laravel.log', [
        'Content-Type' => 'text/plain'
    ]);
});


Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'getCart'])->name('cart.get');
Route::delete('/cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::patch('/cart/{id}/quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::get('/cart/view', [CartController::class, 'view'])->name('cart.view');
