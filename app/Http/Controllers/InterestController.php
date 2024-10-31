<?php

namespace App\Http\Controllers;

use App\Http\Requests\InterestRateCalculateRequest;
use App\Http\Requests\InterestRateRequest;
use App\Interfaces\Services\InterestRateServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class InterestController extends Controller
{
    private InterestRateServiceInterface $interestRateService;

    public function __construct(InterestRateServiceInterface $interestRateService)
    {
        $this->interestRateService = $interestRateService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(InterestRateRequest $request)
    {
        $request->validated();
        return $this->interestRateService->list($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InterestRateRequest $request)
    {
        return $this->interestRateService->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->interestRateService->findById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InterestRateRequest $request, string $id)
    {
        return $this->interestRateService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->interestRateService->delete($id);
    }

    public function interestCalculate(InterestRateCalculateRequest $request)
    {
        return $this->interestRateService->calculate($request);
    }
}
