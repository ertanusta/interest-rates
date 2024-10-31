<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class BankRequest extends FormRequest
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
                'with' => 'string|'
            ],
            Request::METHOD_POST => [
                "name" => "required|string",
                "description" => "required|string"
            ],
            Request::METHOD_PUT => [
                "name" => "string",
                "description" => "string"
            ],
        };
    }

    public function messages()
    {
        return [
            'page.integer' => 'The page must be an integer.',
            'limit.integer' => 'The limit must be an integer.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
        ];
    }
}
