<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
    // Paksa URL ke HTTPS
    \Illuminate\Support\Facades\URL::forceScheme('https');

    // Tambahkan ini agar Cookie Session aman di HTTPS Railway
    if (config('app.env') !== 'local') {
        \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
    }
}
}
