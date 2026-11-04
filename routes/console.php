<?php

use Illuminate\Foundation\Inspiring;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Default Artisan Command
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// 1. Product In Sync
Schedule::command('app:sync-product-in')
        ->everyMinute()
        ->withoutOverlapping(10)
        ->runInBackground();

// 2. Product Out Sync`
Schedule::command('app:sync-product-out')
        ->everyMinute()
        ->withoutOverlapping(10)
        ->runInBackground();

// 3. Completing Data Sync
Schedule::command('sensor:complete-data')
        ->everyMinute()
        ->withoutOverlapping(10)
        ->onOneServer()
        ->runInBackground();

// 4. Summary Data Sync
Schedule::command('sensor:summary-data')
        ->everyMinute()
        ->withoutOverlapping(10)
        ->onOneServer()
        ->runInBackground();
