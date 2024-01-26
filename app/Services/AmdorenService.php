<?php

namespace App\Services;

use App\Http\Controllers\CurrencyInterface;

class AmdorenService implements CurrencyInterface
{
    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return array
     */
    public function convert(string $from, string $to, float $amount): array
    {
        $url = config('services.amdoren.base_url');
        $apiKey = config('services.amdoren.api_key');

        $apiService = new ExternalAPIService($url, $apiKey);
        $response = $apiService->apiClient($from, $to, $amount);

        return $response->json();
    }
}
