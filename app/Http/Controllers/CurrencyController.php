<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

interface CurrencyInterface
{
    /**
     * Convert the given amount from one currency to another.
     *
     * @param float $amount
     * @param string $from
     * @param string $to
     * @return mixed
     */
    public function convert(float $amount, string $from, string $to);
}

class CurrencyController extends Controller
{
    /**
     * Convert the currency using the specified service.
     *
     * @param CurrencyInterface $currency
     * @return array
     */
    public function convert(CurrencyInterface $currency)
    {
        $validateData = request()->validate([
            'amount' => ['required', 'numeric', 'min:0.1'],
            'from' => ['required', 'string', 'size:3'],
            'to' => ['required', 'string', 'size:3'],
        ]);

        $amount = $validateData['amount'];
        $from = $validateData['from'];
        $to = $validateData['to'];

        $response = $currency->convert($amount, $from, $to);

        if (isset($response['error_message']) && $response['error_message'] !== '') {
            throw new \Exception('Error: ' . $response['error_message']);
        }

        return [
            'converted' => $response['amount'],
            'currency' => $to,
        ];
    }
}

class Api
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
    public function apiClient($amount, $from, $to)
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

}

class AmdorenService implements CurrencyInterface
{
    /**
     * Convert the currency using Amdoren service.
     *
     * @param $amount
     * @param $from
     * @param $to
     * @return array|mixed
     */
    public function convert($amount, $from, $to)
    {
        $url = config('services.amdoren.base_url');
        $apiKey = config('services.amdoren.api_key');

        $apiSimulator = new Api($url, $apiKey);
        $response = $apiSimulator->apiClient($amount, $from, $to);

        return $response->json();
    }
}

class FixerService implements CurrencyInterface
{
    /**
     * Convert the currency using Fixer service.
     *
     * @param $amount
     * @param $from
     * @param $to
     * @return array|mixed
     */
    public function convert($amount, $from, $to)
    {
        $url = config('services.fixer.base_url');
        $apiKey = config('services.fixer.api_key');

        $apiSimulator = new Api($url, $apiKey);
        $response = $apiSimulator->apiClient($amount, $from, $to);

        return $response->json();
    }
}


