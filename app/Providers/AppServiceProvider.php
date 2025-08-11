<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\LoaiMon;
use App\Models\MonAn;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('header', function ($view) {
            $view->with('dsLoaiMon', LoaiMon::all());
        });
        View::composer('home', function ($view) {
            $view->with('dsLoaiMon', LoaiMon::all());
        });
        View::composer('home', function ($view) {
            $view->with('dsMonAn', MonAn::all());
        });
    }
}
