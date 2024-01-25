<?php

// http://127.0.0.1:8000/currency/api/store?amount=23.34&from=EUR&to=USD

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
    /**
     * @param CurrencyInterface $currency
     * @return array
     */
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

class FakeApi
{
    protected string $base_url;
    protected string $api_key;

    public function __construct($base_url, $api_key)
    {
        $this->base_url = $base_url;
        $this->api_key = $api_key;
    }

    /**
     * @param $amount
     * @param $from
     * @param $to
     * @return \Illuminate\Http\Client\Response
     */
    public function getQueryParameters($amount, $from, $to)
    {

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

class AmdorenService implements CurrencyInterface
{
    /**
     * @param $amount
     * @param $from
     * @param $to
     * @return array|mixed
     */
    public function convert($amount, $from, $to)
    {
        $url = config('services.amdoren.base_url');
        $api_key = config('services.amdoren.api_key');

        $amdorenApi = new FakeApi($url, $api_key);
        $response = $amdorenApi->getQueryParameters($amount, $from, $to);

        return $response->json();
    }
}

class FixerService implements CurrencyInterface
{
    /**
     * @param $amount
     * @param $from
     * @param $to
     * @return array|mixed
     */
    public function convert($amount, $from, $to)
    {
        $url = config('services.fixer.base_url');
        $api_key = config('services.fixer.api_key');

        $fixerApi = new FakeApi($url, $api_key);

        $response = $fixerApi->getQueryParameters($amount, $from, $to);

        return $response->json();
    }
}

$currency = new CurrencyController();

$amdoren = $currency->store(new AmdorenService());
$fixer = $currency->store(new FixerService());

//dd($amdoren);
dd($fixer);
