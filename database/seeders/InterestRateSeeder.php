<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\InterestRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bankA = Bank::where('name', 'A Bank')->first();

        InterestRate::create([
            'bank_id' => $bankA->id,
            'term_days' => 30,
            'rate' => 12.00,
            'daily_rate' => 12.00 / 30,
            'currency' => 'USD',
        ]);

        InterestRate::create([
            'bank_id' => $bankA->id,
            'term_days' => 32,
            'rate' => 12.30,
            'daily_rate' => 12.30 / 32,
            'currency' => 'USD'
        ]);

        InterestRate::create([
            'bank_id' => $bankA->id,
            'term_days' => 45,
            'rate' => 15.00,
            'daily_rate' => 15.00 / 45,
            'currency' => 'TRY'
        ]);

        $bankB = Bank::where('name', 'B Bank')->first();

        InterestRate::create([
            'bank_id' => $bankB->id,
            'term_days' => 30,
            'rate' => 11.00,
            'daily_rate' => 11.00 / 30,
            'currency' => 'EUR',
        ]);

        InterestRate::create([
            'bank_id' => $bankB->id,
            'term_days' => 32,
            'rate' => 11.30,
            'daily_rate' => 11.30 / 32,
            'currency' => 'USD',
        ]);

        InterestRate::create([
            'bank_id' => $bankB->id,
            'term_days' => 45,
            'rate' => 13.00,
            'daily_rate' => 13.00 / 45,
            'currency' => 'TRY',
        ]);
    }
}
