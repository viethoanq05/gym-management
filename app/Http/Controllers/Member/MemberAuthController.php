<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MemberAuthController extends Controller
{
    public function showRegisterForm(): View
    {
        return view('member.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
                'role' => 'member',
            ]);

            Member::create([
                'user_id' => $user->id,
                'gender' => 'male', // default value, updateable later
                'dob' => '2000-01-01', // default value, updateable later
                'height' => 170.00, // default value, updateable later
                'weight' => 65.00, // default value, updateable later
                'join_date' => now()->toDateString(),
            ]);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('member.dashboard')->with('success', 'Đăng ký tài khoản và đăng nhập thành công!');
    }
}

