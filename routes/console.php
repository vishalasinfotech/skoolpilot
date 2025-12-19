<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule subscription auto-renewal to run daily
Schedule::command('subscription:auto-renewal')
    ->daily()
    ->at('02:00')
    ->withoutOverlapping()
    ->runInBackground();
