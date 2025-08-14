<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonAnController;
use Illuminate\Support\Facades\Response;

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
