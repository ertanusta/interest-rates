<?php

namespace App\Repositories;

use App\Constants\CacheConstants;
use App\Interfaces\Repositories\InterestRateRepositoryInterface;
use App\Models\InterestRate;
use Illuminate\Support\Facades\Cache;

class InterestRateRepository implements InterestRateRepositoryInterface
{
    public function listByPaginate(int $limit, int $page)
    {
        if (Cache::tags(CacheConstants::INTEREST_RATE_TAG_LIST)->has(createCacheKey($limit, $page))) {
            return Cache::tags(CacheConstants::INTEREST_RATE_TAG_LIST)->get(createCacheKey($limit, $page));
        }
        $models = InterestRate::paginate($limit, ['*'], 'page', $page);
        Cache::tags(CacheConstants::INTEREST_RATE_TAG_LIST)->put(createCacheKey($limit, $page), $models, 120);
        return $models;
    }

    public function findById($id = null): InterestRate
    {
        if (Cache::tags(CacheConstants::INTEREST_RATE_TAG)->has(createCacheKey($id))) {
            return Cache::tags(CacheConstants::INTEREST_RATE_TAG)->get(createCacheKey($id));
        }
        $model = InterestRate::query()->where('id', $id)->firstOrFail();
        Cache::tags(CacheConstants::INTEREST_RATE_TAG)->put(createCacheKey($id), $model);
        return $model;
    }

    public function create($data): InterestRate
    {
        $model = InterestRate::create($data);
        Cache::tags(CacheConstants::INTEREST_RATE_TAG)->put(createCacheKey($model->id), $model);
        return $model;
    }

    public function update($data, $id): InterestRate
    {
        $model = $this->findById($id);
        $model->fill($data);
        $model->save();
        Cache::tags(CacheConstants::INTEREST_RATE_TAG)->put(createCacheKey($model->id), $model);
        return $model;
    }

    public function delete($id): int
    {
        Cache::tags(CacheConstants::INTEREST_RATE_TAG)->delete(createCacheKey($id));
        return InterestRate::destroy($id);
    }

    public function getAvaibleCurrencies(): array
    {
        if (Cache::tags(CacheConstants::INTEREST_RATE_TAG)->has(createCacheKey('currencies'))) {
            return Cache::tags(CacheConstants::INTEREST_RATE_TAG)->get(createCacheKey('currencies'));
        }
        $currencies = InterestRate::query()->select('currency')
            ->distinct()->pluck('currency')->toArray();
        Cache::tags(CacheConstants::INTEREST_RATE_TAG)->put(createCacheKey('currencies'), $currencies);
        return $currencies;
    }

    public function getAvaibleTermDays(): array
    {
        if (Cache::tags(CacheConstants::INTEREST_RATE_TAG)->has(createCacheKey('term_days'))) {
            return Cache::tags(CacheConstants::INTEREST_RATE_TAG)->get(createCacheKey('term_days'));
        }
        $termDays = InterestRate::query()->select('term_days')
            ->distinct()->pluck('term_days')->toArray();
        Cache::tags(CacheConstants::INTEREST_RATE_TAG)->put(createCacheKey('term_days'), $termDays);
        return $termDays;
    }
}
