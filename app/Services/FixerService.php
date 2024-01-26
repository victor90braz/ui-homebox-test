<?php

namespace App\Services;

use App\Http\Controllers\CurrencyInterface;

class FixerService implements CurrencyInterface
{
    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return array
     */
    public function convert(string $from, string $to, float $amount): array
    {
        $url = config('services.fixer.base_url');
        $apiKey = config('services.fixer.api_key');

        $apiService = new ExternalAPIService($url, $apiKey);
        $response = $apiService->fakeApiRequest($from, $to, $amount);

        return $response->json();
    }
}
