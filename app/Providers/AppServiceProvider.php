<?php

namespace App\Providers;

use App\Http\Controllers\AmdorenService;
use App\Http\Controllers\CurrencyInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CurrencyInterface::class, AmdorenService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
