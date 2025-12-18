<?php

use App\Http\Middleware\EnsureSchoolHasActiveSubscription;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'active-subscription' => EnsureSchoolHasActiveSubscription::class,
            'prevent-back-history' => PreventBackHistory::class,
        ]);

        // Apply SetLocale middleware to all web routes
        $middleware->web(append: [
            SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
