<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankRequest;
use App\Interfaces\Services\BankServiceInterface;
use Illuminate\Http\Request;

class BankController extends Controller
{
    private BankServiceInterface $bankService;

    public function __construct(BankServiceInterface $bankService)
    {
        $this->bankService = $bankService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BankRequest $request)
    {
        $request->validated();
        return $this->bankService->list($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankRequest $request)
    {
        return $this->bankService->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->bankService->findById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankRequest $request, string $id)
    {
        return $this->bankService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->bankService->delete($id);
    }
}
