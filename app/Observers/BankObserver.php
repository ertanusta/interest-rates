<?php

namespace App\Observers;

use App\Constants\CacheConstants;
use App\Models\Bank;
use Illuminate\Support\Facades\Cache;

class BankObserver
{
    /**
     * Handle the Bank "created" event.
     */
    public function create(Bank $bank): void
    {
        Cache::tags(CacheConstants::BANK_TAG_LIST)->flush();

    }

    /**
     * Handle the Bank "updated" event.
     */
    public function update(Bank $bank): void
    {
        Cache::tags(CacheConstants::BANK_TAG_LIST)->flush();
    }

    /**
     * Handle the Bank "deleted" event.
     */
    public function delete(Bank $bank): void
    {
        Cache::tags(CacheConstants::BANK_TAG_LIST)->flush();
    }

    /**
     * Handle the Bank "restored" event.
     */
    public function restored(Bank $bank): void
    {
        //
    }

    /**
     * Handle the Bank "force deleted" event.
     */
    public function forceDeleted(Bank $bank): void
    {
        //
    }
}
