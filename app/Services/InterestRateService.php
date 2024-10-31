<?php

namespace App\Services;

use App\Http\Requests\InterestRateCalculateRequest;
use App\Http\Requests\InterestRateRequest;
use App\Http\Resources\InterestRateCalculateResource;
use App\Http\Resources\InterestRateResource;
use App\Interfaces\Repositories\BankRepositoryInterface;
use App\Interfaces\Repositories\InterestRateRepositoryInterface;
use App\Interfaces\Services\InterestRateServiceInterface;
use App\Models\InterestRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InterestRateService implements InterestRateServiceInterface
{
    private InterestRateRepositoryInterface $interestRateRepository;
    private BankRepositoryInterface $bankRepository;

    public function __construct(
        InterestRateRepositoryInterface $interestRateRepository,
        BankRepositoryInterface         $bankRepository
    )
    {
        $this->interestRateRepository = $interestRateRepository;
        $this->bankRepository = $bankRepository;
    }

    public function list(InterestRateRequest $request): ResourceCollection
    {
        $data = $this->interestRateRepository->listByPaginate(
            $request->get('limit', 10),
            $request->get('page', 1),
            $request->get('with',null)
        );
        return InterestRateResource::collection($data);
    }

    public function findById(string $id): InterestRateResource
    {
        $model = $this->interestRateRepository->findById($id);
        return new InterestRateResource($model);
    }

    public function create(InterestRateRequest $request): InterestRateResource
    {
        $requestData = $request->validated();
        $model = $this->interestRateRepository->create($requestData);
        return new InterestRateResource($model);
    }

    public function update(InterestRateRequest $request, $id): InterestRateResource
    {
        $requestData = $request->validated();
        $model = $this->interestRateRepository->update($requestData, $id);
        return new InterestRateResource($model);
    }

    public function delete($id): JsonResponse
    {
        $status = $this->interestRateRepository->delete($id);
        return response()->json(
            ['message' => $status ? "Resource Deleted" : "Resorce not found."],
            $status ? 200 : 404
        );
    }

    public function calculate(InterestRateCalculateRequest $request): InterestRateCalculateResource
    {
        $requestData = $request->validated();
        [$closestInterestRates, $isCustom] = $this->getClosestInterestRates($requestData['currency'], $requestData['term']);
        $results = [];
        foreach ($closestInterestRates as $closestInterestRate) {
            $results[] = [
                'bank' => $closestInterestRate->bank(),
                'interest_rate' => $closestInterestRate,
                'principal' => (float)$requestData['principal'],
                'term_days' => $requestData['term'],
                'currency' => $requestData['currency'],
                'interest' =>
                    $requestData['principal'] *
                    (($isCustom ? $closestInterestRate->daily_rate : $closestInterestRate->rate) / 100) *
                    ($isCustom ? $requestData['term'] : 1)
            ];
        }
        return new InterestRateCalculateResource($results);
    }

    public function getAvaibleCurrencies(): ResourceCollection
    {
        return new ResourceCollection($this->interestRateRepository->getAvaibleCurrencies());
    }

    public function getAvaibleTermDays(): ResourceCollection
    {
        return new ResourceCollection($this->interestRateRepository->getAvaibleTermDays());
    }

    protected function getClosestInterestRates($currency, $term): array
    {
        $isCustom = false;
        $closestInterestRates = InterestRate::query()
            ->where('currency', '=', $currency)
            ->where('term_days', '=', (int)$term)
            ->get();

        // burada kullanıcı custom bir değer göndermiş ise en yakın vade oranının gününe göre hespalama yapıyoruz
        if ($closestInterestRates->isEmpty()) {
            $closestInterestRates = InterestRate::select('bank_id', 'currency', 'term_days', 'rate', 'daily_rate')
                ->where('currency', '=', $currency)
                ->orderByRaw('ABS(term_days - ?)', [$term])
                ->groupBy('bank_id')
                ->havingRaw('term_days = MIN(term_days)')
                ->get();
            $isCustom = true;
        }
        if ($closestInterestRates->isEmpty()) {
            throw new NotFoundHttpException();
        }
        return [$closestInterestRates, $isCustom];
    }
}
