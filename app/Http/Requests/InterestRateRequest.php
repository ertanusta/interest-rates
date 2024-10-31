<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class InterestRateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return match ($this->method()) {
            Request::METHOD_GET => [
                "limit" => "integer",
                "page" => "integer",
                'with' => 'string'
            ],
            Request::METHOD_POST, Request::METHOD_PUT => [
                "bank_id" => "required|exists:App\Models\Bank,id",
                "term_days" => "required|int",
                "rate" => "required|decimal",
                "daily_rate" => "required|decimal",
                "currency" => "required|string",
            ],
        };
    }
}
