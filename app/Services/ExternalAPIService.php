<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExternalAPIService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct($baseUrl, $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * @param $amount
     * @param $from
     * @param $to
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function apiClient($amount, $from, $to): \Illuminate\Http\Client\Response
    {
        try {
            return Http::get($this->baseUrl, [
                'api_key' => $this->apiKey,
                'amount' => $amount,
                'from' => $from,
                'to' => $to,
            ]);

        } catch (\Exception $e) {
            report($e);
            throw new \Exception('Error during API request: ' . $e->getMessage());
        }
    }

    /**
     * @param $from
     * @param $to
     * @param $amount
     * @return \Illuminate\Http\Client\Response
     */
    public function fakeApiRequest($from,$to,$amount)
    {
        Http::fake([
            Http::response([
                'from' => $from,
                'to' => $to,
                'amount' => $amount,
            ]),
        ]);

        Http::get($this->baseUrl, [
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
        ]);

        return Http::get($this->baseUrl);
    }

}
