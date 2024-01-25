<?php

namespace App\Services;

use App\Http\Controllers\CurrencyInterface;

class AmdorenService implements CurrencyInterface
{
    /**
     * @param $amount
     * @param $from
     * @param $to
     * @return array|mixed
     * @throws \Exception
     */
    public function convert($amount, $from, $to): mixed
    {
        $url = config('services.amdoren.base_url');
        $apiKey = config('services.amdoren.api_key');

        $apiService = new ExternalAPIService($url, $apiKey);
        //$response = $apiService->apiClient($amount, $from, $to);
        $response = $apiService->fakeApiRequest($amount, $from, $to);

        return $response->json();
    }
}
