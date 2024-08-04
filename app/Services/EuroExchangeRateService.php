<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class EuroExchangeRateService
{
    private const EXCHANGE_RATES_URL = 'https://www.bank.lv/vk/ecb.xml';

    public function fetchExchangeRates(string $date = null): array
    {
        $exchangeRatesUrl = self::EXCHANGE_RATES_URL;

        if ($date) {
            $query = http_build_query([
                'date' => $date
            ]);

            $exchangeRatesUrl = $exchangeRatesUrl . '?' . $query;
        }

        $response = Http::get($exchangeRatesUrl);

        if ($response->failed()) {
            throw new RuntimeException('Failed to fetch exchange rates.');
        }

        return $this->parseXml($response->body());
    }

    private function parseXml(string $xmlData): array
    {
        $xml = simplexml_load_string($xmlData);
        $json = json_encode($xml);

        return json_decode($json, TRUE);
    }
}
