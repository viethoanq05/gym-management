<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MemberProfileController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        $user = Auth::user();
        $member = $user->member;

        if (! $member) {
            return response()->json(['message' => 'Tài khoản không phải hội viên.'], 403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'gender' => ['required', 'in:male,female'],
            'dob' => ['required', 'date', 'before:today'],
            'height' => ['required', 'numeric', 'min:50', 'max:300'],
            'weight' => ['required', 'numeric', 'min:20', 'max:500'],
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'dob.required' => 'Vui lòng nhập ngày sinh.',
            'dob.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'height.required' => 'Vui lòng nhập chiều cao.',
            'height.min' => 'Chiều cao tối thiểu 50cm.',
            'weight.required' => 'Vui lòng nhập cân nặng.',
            'weight.min' => 'Cân nặng tối thiểu 20kg.',
        ]);

        $user->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);

        $member->update([
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'height' => $data['height'],
            'weight' => $data['weight'],
        ]);

        return response()->json([
            'message' => 'Cập nhật thông tin thành công!',
            'user' => [
                'name' => $user->fresh()->name,
                'email' => $user->fresh()->email,
                'phone' => $user->fresh()->phone,
            ],
        ]);
    }
}
