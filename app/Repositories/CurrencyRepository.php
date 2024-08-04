<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Currency;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use stdClass;

readonly class CurrencyRepository
{
    public function __construct(
        private Currency $currency
    )
    {
    }

    public function getCurrencyByCode(string $currencyCode): null|stdClass
    {
        $query = "SELECT * FROM currencies WHERE code = :code";

        return DB::selectOne($query, ['code' => $currencyCode]);
    }

    public function createCurrency(string $currencyCode): void
    {
        $now = Carbon::now();

        $query = "
            INSERT INTO currencies (code, created_at, updated_at)
            VALUES (:code, :created_at, :updated_at)
        ";

        $payload = [
            'code' => $currencyCode,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::insert($query, $payload);
    }

    public function getCurrencies(array $filters): Collection
    {
        $dates = $filters['dates'];
        $currencies = $filters['currencies'];

        $query = $this->currency->newQuery();

        if ($dates && count($dates) > 0) {
            $dates = array_map(function (string $date) {
                $format = 'Y-m-d';
                $parsedDate = DateTime::createFromFormat($format, $date);

                if ($parsedDate && $parsedDate->format($format) === $date) {
                    return Carbon::parse($date);
                }

                return null;
            }, $dates);

            $dates = array_filter($dates);

            $query->with(['euroExchangeRates' => function (HasMany $queryBuilder) use ($dates) {
                $queryBuilder->whereIn('rate_relevance_date', $dates)
                    ->orderBy('rate_relevance_date', 'desc');
            }]);
        } else {
            $today = Carbon::today()->startOfDay();

            $query->with(['euroExchangeRates' => function (HasMany $query) use ($today) {
                $query->where('rate_relevance_date', '=', $today);
            }]);
        }

        if ($currencies && count($currencies) > 0) {
            $query->whereIn('code', $currencies);
        }

        return $query->get();
    }

    public function getCurrencyCodes(): Collection
    {
        return $this->currency
            ->select(['id', 'code'])
            ->get();
    }
}
