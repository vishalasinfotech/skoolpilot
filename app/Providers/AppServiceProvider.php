<?php

namespace App\Providers;

use App\Models\StudentFeeTransaction;
use Illuminate\Database\Eloquent\Model;
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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // Route model binding for fee collection
        Route::bind('fee_collection', function ($value) {
            return StudentFeeTransaction::findOrFail($value);
        });
    }
}
