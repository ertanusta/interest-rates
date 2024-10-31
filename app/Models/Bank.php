<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = "banks";
    protected $fillable = ['name','description'];

    public function interestRates()
    {
        return $this->hasMany(InterestRate::class)->get();
    }
}
