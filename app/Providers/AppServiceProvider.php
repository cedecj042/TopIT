<?php

namespace App\Providers;

use App\Livewire\EditModule;
use Illuminate\Support\ServiceProvider;
use App\Services\FastApiService;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Livewire\Livewire;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FastAPIService::class, function ($app) {
            return new FastAPIService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
