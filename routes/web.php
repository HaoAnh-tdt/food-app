<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonAnController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/monan', [MonAnController::class, 'index']);
Route::get('/monan/{maloai}', [MonAnController::class, 'showbyLoai'])->name('monan.theoloai');
