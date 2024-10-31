<?php

namespace App\Services;

use App\Http\Requests\BankRequest;
use App\Http\Resources\BankResource;
use App\Interfaces\Repositories\BankRepositoryInterface;
use App\Interfaces\Services\BankServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BankService implements BankServiceInterface
{
    private BankRepositoryInterface $bankRepository;

    public function __construct(BankRepositoryInterface $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    public function list(BankRequest $request): ResourceCollection
    {
        $data = $this->bankRepository->listByPaginate(
            $request->get('limit', 10),
            $request->get('page', 1)
        );
        return BankResource::collection($data);
    }

    public function findById($id): BankResource
    {
        $model = $this->bankRepository->findById($id);
        return new BankResource($model);
    }

    public function create(BankRequest $request): BankResource
    {
        $requestData = $request->validated();
        $model = $this->bankRepository->create($requestData);
        return new BankResource($model);
    }

    public function update(BankRequest $request, $id): BankResource
    {
        $requestData = $request->validated();
        $model = $this->bankRepository->update($requestData, $id);
        return new BankResource($model);
    }

    public function delete($id): JsonResponse
    {
       $status =  $this->bankRepository->delete($id);
       return  response()->json(['message' => $status ? "Resource Deleted" : "Resorce not found."], $status ? 200 : 404);
    }
}
