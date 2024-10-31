<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bank::create(['name' => 'A Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => 'B Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => 'C Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => 'E Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => 'F Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => 'G Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => 'H Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => '1 Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => '2 Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => '3 Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => '4 Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => '5 Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => '6 Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => '7 Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => '8 Bank', 'description' => 'A Bank is a bank']);
        Bank::create(['name' => '9 Bank', 'description' => 'A Bank is a bank']);
    }
}
