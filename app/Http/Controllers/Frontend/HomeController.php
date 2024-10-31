<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\InterestRateServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private InterestRateServiceInterface $interestRate;

    public function __construct(InterestRateServiceInterface $interestRate)
    {
        $this->interestRate = $interestRate;
    }

    public function index()
    {
        $currencies = $this->interestRate->getAvaibleCurrencies();
        $termDays = $this->interestRate->getAvaibleTermDays();
        return view('index',compact('currencies', 'termDays'));
    }
}
