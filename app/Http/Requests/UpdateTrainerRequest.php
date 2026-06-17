<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTrainerRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules()
    {
        $routeParam = $this->route('trainer');
        $userId = is_numeric($routeParam) ? $routeParam : ($routeParam->id ?? $this->input('user_id'));

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],

            'description' => ['nullable', 'string'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
