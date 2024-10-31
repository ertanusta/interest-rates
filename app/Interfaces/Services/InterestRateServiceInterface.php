<?php

namespace App\Interfaces\Services;

use App\Http\Requests\InterestRateCalculateRequest;
use App\Http\Requests\InterestRateRequest;
use App\Http\Resources\InterestRateCalculateResource;
use App\Http\Resources\InterestRateResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface InterestRateServiceInterface
{

    public function list(InterestRateRequest $request): ResourceCollection;

    public function findById(string $id): InterestRateResource;

    public function create(InterestRateRequest $request): InterestRateResource;

    public function update(InterestRateRequest $request, $id): InterestRateResource;

    public function delete($id): JsonResponse;

    public function calculate(InterestRateCalculateRequest $request): InterestRateCalculateResource;

    public function getAvaibleCurrencies(): ResourceCollection;

    public function getAvaibleTermDays() : ResourceCollection;
}
