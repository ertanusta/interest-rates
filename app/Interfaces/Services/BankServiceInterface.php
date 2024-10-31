<?php

namespace App\Interfaces\Services;

use App\Http\Requests\BankRequest;
use App\Http\Resources\BankResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface BankServiceInterface
{

    public function list(BankRequest $request): ResourceCollection;

    public function findById(string $id): BankResource;

    public function create(BankRequest $request): BankResource;

    public function update(BankRequest $request, $id): BankResource;

    public function delete($id): JsonResponse;
}
