<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use mysql_xdevapi\Exception;

class CurrencyController extends Controller
{
    const QUERY_PARAMETER_AS_DEFAULT = 'GBP';

    /**
     * @param CurrencyInterface $currency
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CurrencyInterface $currency)
    {
        $validateData = request()->validate([
            'from' => ['sometimes', 'string', 'size:3'],
            'to' => ['required', 'string', 'size:3'],
            'amount' => ['required', 'numeric'],
        ]);

        $validateData['from'] = self::QUERY_PARAMETER_AS_DEFAULT;

        $response = $currency->convert($validateData['from'], $validateData['to'], $validateData['amount']);

        if (array_key_exists('error', $response)) {
            report($response['error_message']);
            return redirect('/')->withErrors('Something went wrong! We will back soon.');
        }

        return [
            'converted' => $response['amount'],
            'currency' => $response['to'],
        ];

    }
}








