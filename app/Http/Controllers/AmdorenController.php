<?php

namespace App\Http\Controllers;

use App\Services\AmdorenService;

class AmdorenController extends Controller
{
    /**
     * @param CurrencyController $currencyController
     * @return array
     */
    public function convert(CurrencyController $currencyController)
    {
        return $currencyController->store(new AmdorenService());
    }
}
