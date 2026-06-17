<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer', 'in:0,1'],
        ];
    }
}
