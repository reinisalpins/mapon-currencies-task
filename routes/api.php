<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\EuroExchangeRatesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/currencies', [CurrencyController::class, 'getCurrencies']);
Route::get('/currencies/codes', [CurrencyController::class, 'getCurrencyCodes']);
Route::get('/exchange-rates/available-dates', [EuroExchangeRatesController::class, 'getAvailableDates']);
