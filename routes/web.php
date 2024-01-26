<?php

use App\Http\Controllers\AmdorenController;
use App\Http\Controllers\FixerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/currency/api/convert-amdoren', [AmdorenController::class, 'convert'])->name('currency.convert.amdoren');
Route::get('/currency/api/convert-fixer', [FixerController::class, 'convert'])->name('currency.convert.fixer');


