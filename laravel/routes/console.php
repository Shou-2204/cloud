<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Rating digest schedules
Schedule::command('ratings:send-digest daily')->dailyAt('08:00');
Schedule::command('ratings:send-digest weekly')->weeklyOn(1, '08:00'); // Monday at 8h
Schedule::command('ratings:send-digest monthly')->monthlyOn(1, '08:00'); // 1st of month at 8h

// Sitemap regeneration
Schedule::command('sitemap:generate')->daily();

// Loyalty Rewards Cleanup (Delete soft-deleted rewards older than a year)
Schedule::command('loyalty:cleanup-rewards')->daily();
