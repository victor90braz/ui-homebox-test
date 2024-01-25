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
        $response = $this->fakeApiRequest($amount, $from, $to);

        return $response->json();
    }
    public function fakeApiRequest($amount, $from, $to)
    {
        // http://127.0.0.1:8000/currency/api/store?amount=23.34&from=EUR&to=USD

        Http::fake([
            'https://www.amdoren.com/api/currency.php' => Http::response([
                'amount' => $amount,
                'from' => $from,
                'to' => $to,
            ]),
        ]);

        Http::get('https://www.amdoren.com/api/currency.php', [
            'amount' => $amount,
            'from' => $from,
            'to' => $to,
        ]);

        return Http::get('https://www.amdoren.com/api/currency.php');
    }

}

$currencyController = new CurrencyController();

$amdorenService = $currencyController->store(new AmdorenService());
