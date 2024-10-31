<?php

namespace App\Models;

use App\Observers\InterestRateObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([InterestRateObserver::class])]
class InterestRate extends Model
{

    protected $table = "interest_rates";
    protected $fillable = ['bank_id', 'term_days', 'rate', 'daily_rate','currency'];

    public function bank()
    {
        return $this->belongsTo(Bank::class)->first();
    }
}
