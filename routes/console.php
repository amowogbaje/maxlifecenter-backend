<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
// use App\Console\Commands\SyncWooOrders;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('woo:sync-orders')->dailyAt('1:00');
Schedule::command('woo:sync-products')->dailyAt('2:00');
// Schedule::command('users:update-bonus-points')->daily();
// Schedule::command('log:five-minutes')->everyFiveMinutes();
// Schedule::command('reward:send-initial-emails')->daily();
// Schedule::command('reward:send-reminders')->twiceMonthly(1, 15);
// Schedule::command('reward:send-approval-emails')->daily();