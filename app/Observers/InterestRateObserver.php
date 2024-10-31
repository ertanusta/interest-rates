<?php

namespace App\Observers;

use App\Constants\CacheConstants;
use App\Models\InterestRate;
use Illuminate\Support\Facades\Cache;

class InterestRateObserver
{
    /**
     * Handle the InterestRate "created" event.
     */
    public function create(InterestRate $interestRate): void
    {
        Cache::tags(CacheConstants::INTEREST_RATE_TAG_LIST)->flush();
        $interestRate->daily_rate = $interestRate->rate / $interestRate->term_days;
    }

    /**
     * Handle the InterestRate "updated" event.
     */
    public function update(InterestRate $interestRate): void
    {
        Cache::tags(CacheConstants::INTEREST_RATE_TAG_LIST)->flush();
        $interestRate->daily_rate = $interestRate->rate / $interestRate->term_days;
    }

    /**
     * Handle the InterestRate "deleted" event.
     */
    public function delete(InterestRate $interestRate): void
    {
        Cache::tags(CacheConstants::INTEREST_RATE_TAG_LIST)->flush();
    }

    /**
     * Handle the InterestRate "restored" event.
     */
    public function restored(InterestRate $interestRate): void
    {
        //
    }

    /**
     * Handle the InterestRate "force deleted" event.
     */
    public function forceDeleted(InterestRate $interestRate): void
    {
        //
    }
}
