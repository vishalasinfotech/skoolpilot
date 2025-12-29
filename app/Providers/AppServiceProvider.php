<?php

namespace App\Providers;

use App\Models\StudentFeeTransaction;
use App\Services\SettingService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Route::bind('fee_collection', function ($value) {
            return StudentFeeTransaction::query()->findOrFail($value);
        });
    }
}
