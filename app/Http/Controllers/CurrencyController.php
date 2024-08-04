<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GetCurrenciesRequest;
use App\Http\Resources\CurrencyCodeResourceCollection;
use App\Http\Resources\CurrencyResourceCollection;
use App\Repositories\CurrencyRepository;

class CurrencyController extends Controller
{
    public function __construct(
        private readonly CurrencyRepository $currencyRepository
    )
    {
    }

    public function getCurrencies(GetCurrenciesRequest $exchangeRatesRequest): CurrencyResourceCollection
    {
        return new CurrencyResourceCollection(
            $this->currencyRepository->getCurrencies($exchangeRatesRequest->filters())
        );
    }

    public function getCurrencyCodes(): CurrencyCodeResourceCollection
    {
        return new CurrencyCodeResourceCollection(
            $this->currencyRepository->getCurrencyCodes()
        );
    }
}
