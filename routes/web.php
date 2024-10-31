<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\InterestController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1'], function () {
    Route::apiResource('banks', BankController::class);
    Route::apiResource('interest-rates', InterestController::class);
    Route::post('interest-rates/calculate', [InterestController::class,'interestCalculate']);
});

Route::get('/',[HomeController::class,'index'])->name('frontend.home.index');
