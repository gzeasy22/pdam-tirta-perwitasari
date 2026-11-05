<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // 👈 1. Import class Paginator-nya di sini

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
        // 👇 2. Panggil fungsi ini biar paginasinya pakai gaya Bootstrap
        Paginator::useBootstrapFive(); 
    }
}