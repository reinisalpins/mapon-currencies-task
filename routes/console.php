<?php

use App\Console\Commands\LoadEuroExchangeRates;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(LoadEuroExchangeRates::class)
    ->description('Load euro exchange rates for today at 20:00 UTC, 17:00 latvian time, the exchange rates get posted at 15-16 latvian time')
    ->dailyAt('20:00');
