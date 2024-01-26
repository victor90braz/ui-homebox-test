<?php

namespace App\Http\Controllers;

use App\Services\FixerService;


class FixerController extends Controller
{
    /**
     * @param CurrencyController $currencyController
     * @return array
     */
    public function convert(CurrencyController $currencyController)
    {
        return $currencyController->store(new FixerService());
    }
}
