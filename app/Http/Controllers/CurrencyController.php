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
        $amount = request('amount');
        $from = request('from');
        $to = request('to');

        $response = $currency->convert($amount, $from, $to);

        return [
            'converted' => $response['amount'],
            'currency' => $response['to'],
        ];
    }
}

class ApiSimulator
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct($baseUrl, $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Simulate making a request to the API.
     *
     * @param $amount
     * @param $from
     * @param $to
     * @return \Illuminate\Http\Client\Response
     */
    public function simulateRequest($amount, $from, $to)
    {
        Http::fake([
            $this->baseUrl => Http::response([
                'amount' => $amount,
                'from' => $from,
                'to' => $to,
            ]),
        ]);

        Http::get($this->baseUrl, [
            'api_key' =>  $this->apiKey,
            'amount' => $amount,
            'from' => $from,
            'to' => $to,
        ]);

        return Http::get($this->baseUrl);
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

        $apiSimulator = new ApiSimulator($url, $apiKey);
        $response = $apiSimulator->simulateRequest($amount, $from, $to);

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

        $apiSimulator = new ApiSimulator($url, $apiKey);
        $response = $apiSimulator->simulateRequest($amount, $from, $to);

        return $response->json();
    }
}

$currency = new CurrencyController();

$amdoren = $currency->convert(new AmdorenService());
$fixer = $currency->convert(new FixerService());

dd($amdoren);
//dd($fixer);
