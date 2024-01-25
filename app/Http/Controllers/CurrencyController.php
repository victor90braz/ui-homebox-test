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
     * @param CurrencyInterface $currency
     * @return array
     * @throws \Exception
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
     * @param $amount
     * @param $from
     * @param $to
     * @return array|mixed
     * @throws \Exception
     */
    public function convert($amount, $from, $to)
    {
        $url = config('services.amdoren.base_url');
        $apiKey = config('services.amdoren.api_key');

        $apiService = new ExternalAPIService($url, $apiKey);
        $response = $apiService->apiClient($amount, $from, $to);

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
     * @throws \Exception
     */
    public function convert($amount, $from, $to)
    {
        $url = config('services.fixer.base_url');
        $apiKey = config('services.fixer.api_key');

        $apiService = new ExternalAPIService($url, $apiKey);
        $response = $apiService->apiClient($amount, $from, $to);

        return $response->json();
    }
}


