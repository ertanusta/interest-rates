<?php

namespace App\Interfaces\Repositories;


use App\Models\Bank;

interface BankRepositoryInterface
{
    public function listByPaginate(int $limit, int $page);

    public function findById($id = null): Bank;

    public function create($data): Bank;

    public function update($data, $id): Bank;

    public function delete($id): int;
}
