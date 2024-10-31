<?php

namespace App\Repositories;

use App\Constants\CacheConstants;
use App\Interfaces\Repositories\BankRepositoryInterface;
use App\Models\Bank;
use Illuminate\Support\Facades\Cache;

class BankRepoistory implements BankRepositoryInterface
{

    public function listByPaginate($limit, $page)
    {
        if (Cache::tags(CacheConstants::BANK_TAG_LIST)->has(createCacheKey($limit, $page))) {
            return Cache::tags(CacheConstants::BANK_TAG_LIST)->get(createCacheKey($limit, $page));
        }
        $models = Bank::paginate($limit, ['*'], 'page', $page);
        Cache::tags(CacheConstants::BANK_TAG_LIST)->put(createCacheKey($limit, $models), $models,120);
        return $models;
    }

    public function findById($id = null): Bank
    {
        if (Cache::tags(CacheConstants::BANK_TAG)->has(createCacheKey($id))) {
            return Cache::tags(CacheConstants::BANK_TAG)->get(createCacheKey($id));
        }
        $model = Bank::query()->where('id', $id)->firstOrFail();
        Cache::tags(CacheConstants::BANK_TAG)->put(createCacheKey($id), $model,120);
        return $model;
    }

    public function create($data): Bank
    {
        $model = Bank::create($data);
        Cache::tags(CacheConstants::BANK_TAG)->put(createCacheKey($model->id), $model,120);
        return $model;
    }

    public function update($data, $id): Bank
    {
        $model = $this->findById($id);
        $model->fill($data);
        $model->save();
        Cache::tags(CacheConstants::BANK_TAG)->put(createCacheKey($model->id), $model,120);
        return $model;
    }

    public function delete($id): int
    {
        Cache::tags(CacheConstants::BANK_TAG)->delete(createCacheKey($id));
        return Bank::destroy($id);
    }
}
