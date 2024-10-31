<?php

namespace App\Interfaces\Repositories;


use App\Models\InterestRate;

interface InterestRateRepositoryInterface
{
    public function listByPaginate(int $limit, int $page);

    public function findById($id = null): InterestRate;

    public function create($data): InterestRate;

    public function update($data, $id): InterestRate;

    public function delete($id): int;

    public function getAvaibleCurrencies(): array;

    public function getAvaibleTermDays(): array;
}
