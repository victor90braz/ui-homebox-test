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
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function apiClient(string $from, string $to, float $amount): \Illuminate\Http\Client\Response
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
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return \Illuminate\Http\Client\Response
     */
    public function fakeApiRequest(string $from, string $to, float $amount)
    {
        Http::fake([
            $this->baseUrl => Http::response([
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
