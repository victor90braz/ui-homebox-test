<?php

namespace App\Providers;

use App\Http\Controllers\CurrencyInterface;
use App\Services\AmdorenService;
use App\Services\FixerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CurrencyInterface::class, AmdorenService::class);
        $this->app->bind(CurrencyInterface::class, FixerService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
