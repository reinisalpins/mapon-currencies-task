<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\EuroExchangeRate;
use App\Services\EuroExchangeRateService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

readonly class EuroExchangeRateRepository
{
    public function __construct(
        private EuroExchangeRateService $exchangeRateService,
        private CurrencyRepository      $currencyRepository,
        private EuroExchangeRate        $euroExchangeRate
    )
    {
    }

    /**
     * @throws Exception
     */
    public function loadAndSaveExchangeRatesForToday(): void
    {
        $todayDate = Carbon::now()->format('Ymd');
        $exchangeRates = $this->exchangeRateService->fetchExchangeRates();

        $this->processExchangeRates(
            exchangeRates: $exchangeRates,
            rateRelevanceDate: $todayDate
        );
    }

    /**
     * @throws Exception
     */
    public function loadAndSaveExchangeRatesForPastWeek(): void
    {
        $now = Carbon::now();

        // loop 7 times
        for ($i = 0; $i < 7; $i++) {
            $rateRelevanceDate = $now->copy()->subDays($i)->format('Ymd');

            $exchangeRates = $this->exchangeRateService->fetchExchangeRates($rateRelevanceDate);

            $this->processExchangeRates(
                exchangeRates: $exchangeRates,
                rateRelevanceDate: $rateRelevanceDate
            );
        }
    }

    private function createEuroExchangeRate(
        int    $currencyId,
        float  $rate,
        string $rateRelevanceDate
    ): void
    {
        $now = Carbon::now();
        $rateRelevanceDate = Carbon::createFromFormat('Ymd', $rateRelevanceDate)->startOfDay();

        //prevent duplicates
        $exists = $this->checkIfEuroExchangeRateExists($currencyId, $rateRelevanceDate, $rate);

        if ($exists) {
            return;
        }

        $query = "
            INSERT INTO euro_exchange_rates (currency_id, rate, rate_relevance_date, created_at, updated_at)
            VALUES (:currency_id, :rate, :rate_relevance_date, :created_at, :updated_at)
        ";

        $payload = [
            'currency_id' => $currencyId,
            'rate' => $rate,
            'rate_relevance_date' => $rateRelevanceDate,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::insert($query, $payload);
    }

    /**
     * @throws Exception
     */
    private function processExchangeRates(array $exchangeRates, string $rateRelevanceDate): void
    {
        if (!array_key_exists('Currencies', $exchangeRates)) {
            $this->markAsFailed(
                errorMessage: $exchangeRates[0],
                failedDate: $rateRelevanceDate
            );

            return;
        }

        foreach ($exchangeRates['Currencies']['Currency'] as $currency) {
            $currencyCode = $currency['ID'];
            $rate = $currency['Rate'];
            $date = $exchangeRates['Date'];

            $currency = $this->currencyRepository->getCurrencyByCode($currencyCode);

            if (!$currency) {
                $this->currencyRepository->createCurrency($currencyCode);

                $currency = $this->currencyRepository->getCurrencyByCode($currencyCode);
            }

            $this->createEuroExchangeRate(
                currencyId: $currency->id,
                rate: (float)$rate,
                rateRelevanceDate: $date
            );
        }
    }

    private function markAsFailed(string $errorMessage, string $failedDate): void
    {
        $now = Carbon::now();
        $query = "
            INSERT INTO failed_euro_exchange_rate_requests (requested_date, error_message, created_at, updated_at)
            VALUES (:requested_date, :error_message, :created_at, :updated_at)
        ";

        $payload = [
            'requested_date' => $failedDate,
            'error_message' => $errorMessage,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::insert($query, $payload);
    }

    public function getAvailableDates(): Collection
    {
        return $this->euroExchangeRate->select('rate_relevance_date')
            ->distinct()
            ->orderBy('rate_relevance_date', 'desc')
            ->take(7)
            ->get();
    }

    private function checkIfEuroExchangeRateExists(
        int    $currencyId,
        Carbon $rateRelevanceDate,
        float  $rate
    ): null|stdClass
    {
        $query = "SELECT * FROM euro_exchange_rates WHERE currency_id = :currency_id AND rate_relevance_date = :rate_relevance_date AND rate = :rate";

        $payload = [
            'currency_id' => $currencyId,
            'rate_relevance_date' => $rateRelevanceDate,
            'rate' => $rate,
        ];

        return DB::selectOne($query, $payload);
    }
}
