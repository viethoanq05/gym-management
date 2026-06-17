<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMemberRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'gender' => ['nullable', 'in:male,female,other'],
            'dob' => ['nullable', 'date'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'join_date' => ['nullable', 'date'],
        ];
    }
}
