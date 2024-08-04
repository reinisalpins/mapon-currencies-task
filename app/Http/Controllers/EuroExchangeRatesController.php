<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\AvailableDateResourceCollection;
use App\Repositories\EuroExchangeRateRepository;

class EuroExchangeRatesController extends Controller
{
    public function __construct(
        private readonly EuroExchangeRateRepository $exchangeRateRepository
    )
    {
    }

    public function getAvailableDates(): AvailableDateResourceCollection
    {
        return new AvailableDateResourceCollection(
            $this->exchangeRateRepository->getAvailableDates()
        );
    }
}
