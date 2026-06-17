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
            'price' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string'],
            'status' => ['required', 'integer', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên gói tập là trường bắt buộc.',
            'name.max' => 'Tên gói tập không được dài quá 255 ký tự.',
            'price.required' => 'Giá tiền là trường bắt buộc.',
            'price.numeric' => 'Giá tiền phải là một số hợp lệ.',
            'price.min' => 'Giá tiền phải lớn hơn hoặc bằng 0.',
            'price.max' => 'Giá tiền không được vượt quá 99,999,999 VNĐ.',
            'duration_days.required' => 'Thời hạn là trường bắt buộc.',
            'duration_days.integer' => 'Thời hạn phải là số nguyên.',
            'duration_days.min' => 'Thời hạn phải lớn hơn hoặc bằng 1 ngày.',
            'description.required' => 'Mô tả là trường bắt buộc.',
            'status.required' => 'Trạng thái là trường bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
