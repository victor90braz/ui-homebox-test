<?php

use App\Http\Controllers\AmdorenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/currency/api/convert-amdoren', [AmdorenController::class, 'convert'])->name('currency.convert.amdoren');



