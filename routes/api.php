<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MonAnApiController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiOrderController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::post('/login', [ApiAuthController::class, 'login']);

// các route cần auth
Route::middleware('auth.apitoken')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    // ... các API khác
});


//=========================== API Routes ===========================
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/monan', [MonAnApiController::class, 'index']); // Lấy tất cả món ăn
Route::get('/monan/loai/{maloai}', [MonAnApiController::class, 'showByLoai']); // Lấy món ăn theo loại

Route::middleware('auth.apitoken')->group(function () {
    Route::get('/orders', [ApiOrderController::class, 'index']);
    Route::get('/orders/{id}', [ApiOrderController::class, 'show']);
});