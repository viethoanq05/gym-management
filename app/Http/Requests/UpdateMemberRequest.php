<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules()
    {
        $userId = null;
        // cố gắng lấy user id từ route (có thể là user id hoặc Member model)
        $routeParam = $this->route('member');
        if (is_object($routeParam) && property_exists($routeParam, 'id')) {
            $userId = $routeParam->id;
        } elseif (is_numeric($routeParam)) {
            $userId = $routeParam;
        } else {
            $userId = $this->input('user_id');
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],

            'gender' => ['nullable', 'in:male,female,other'],
            'dob' => ['nullable', 'date'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'join_date' => ['nullable', 'date'],
        ];
    }
}
