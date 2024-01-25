<?php

namespace App\Services;

use App\Http\Controllers\CurrencyInterface;

class AmdorenService implements CurrencyInterface
{
    /**
     * @param $from
     * @param $to
     * @param $amount
     * @return mixed
     */
    public function convert(string $from, string $to, float $amount): mixed
    {
        $url = config('services.amdoren.base_url');
        $apiKey = config('services.amdoren.api_key');

        $apiService = new ExternalAPIService($url, $apiKey);
        $response = $apiService->fakeApiRequest($from, $to, $amount);

        return $response->json();
    }
}