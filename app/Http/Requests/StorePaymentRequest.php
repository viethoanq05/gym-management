<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'package_id' => ['required', 'integer', 'exists:packages,id'],
            'amount' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', 'integer', 'in:1,2,3'],
        ];
    }

    public function messages(): array
    {
        return [
            'member_id.required' => 'Hội viên là trường bắt buộc.',
            'member_id.integer' => 'Hội viên không hợp lệ.',
            'member_id.exists' => 'Hội viên không tồn tại.',
            'package_id.required' => 'Gói tập là trường bắt buộc.',
            'package_id.integer' => 'Gói tập không hợp lệ.',
            'package_id.exists' => 'Gói tập không tồn tại.',
            'amount.required' => 'Số tiền là trường bắt buộc.',
            'amount.numeric' => 'Số tiền phải là một số hợp lệ.',
            'amount.min' => 'Số tiền phải lớn hơn hoặc bằng 0.',
            'amount.max' => 'Số tiền không được vượt quá 99,999,999 VNĐ.',
            'payment_date.required' => 'Ngày thanh toán là trường bắt buộc.',
            'payment_date.date' => 'Ngày thanh toán không hợp lệ.',
            'payment_method.required' => 'Phương thức thanh toán là trường bắt buộc.',
            'payment_method.integer' => 'Phương thức thanh toán không hợp lệ.',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ.',
        ];
    }
}
