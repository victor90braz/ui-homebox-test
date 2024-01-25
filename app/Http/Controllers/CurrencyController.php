<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

interface CurrencyInterface
{
    /**
     * @param float $amount
     * @param string $from
     * @param string $to
     * @return mixed
     */
    public function convert(float $amount, string $from, string $to);
}

class CurrencyController extends Controller
{
    public function store(CurrencyInterface $currency)
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

class AmdorenService implements CurrencyInterface
{
    public function convert($amount, $from, $to)
    {
        $url = config('services.amdoren.base_url');
        $api_key = config('services.amdoren.base_url');

        $amdorenApi = new FakeApi($url,$api_key);
        $response = $amdorenApi->getQueryParameters($amount, $from, $to);

        return $response->json();
    }

}

class FixerService implements CurrencyInterface
{
    public function convert($amount, $from, $to)
    {
        $url = config('services.fixer.base_url');
        $api_key = config('services.fixer.base_url');

        $fixerApi = new FakeApi($url,$api_key);

        $response = $fixerApi->getQueryParameters($amount, $from, $to);

        return $response->json();
    }

}

class FakeApi
{
    protected string $base_url;
    protected string $api_key;

    public function __construct($base_ulr, $api_key)
    {
        $this->base_url = $base_ulr;
        $this->api_key = $api_key;
    }

    public function getQueryParameters($amount, $from, $to)
    {
        // http://127.0.0.1:8000/currency/api/store?amount=23.34&from=EUR&to=USD

        Http::fake([
            $this->base_url => Http::response([
                'amount' => $amount,
                'from' => $from,
                'to' => $to,
            ]),
        ]);

        Http::get($this->base_url, [
            'api_key' =>  $this->api_key,
            'amount' => $amount,
            'from' => $from,
            'to' => $to,
        ]);

        return Http::get($this->base_url);
    }
}

$currency = new CurrencyController();

$amdoren = $currency->store(new AmdorenService());

var_dump($amdoren);
