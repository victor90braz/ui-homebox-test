<?php

namespace App\Services;

use App\Http\Controllers\CurrencyInterface;

class FixerService implements CurrencyInterface
{
    /**
     * @param $amount
     * @param $from
     * @param $to
     * @return array|mixed
     * @throws \Exception
     */
    public function convert( $from, $to, $amount,): mixed
    {
        $url = config('services.fixer.base_url');
        $apiKey = config('services.fixer.api_key');

        $apiService = new ExternalAPIService($url, $apiKey);

        $response = $apiService->fakeApiRequest($from, $to, $amount, );

        return $response->json();
    }
}
