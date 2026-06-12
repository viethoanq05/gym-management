<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $role = Auth::user()->role ?? null;

            return match ($role) {
                'admin' => redirect()->intended('/admin/dashboard'),
                'trainer' => redirect()->intended('/trainer/dashboard'),
                'member' => redirect()->intended('/member/dashboard'),
                'staff' => redirect()->intended('/staff/dashboard'),
                default => redirect()->intended('/'),
            };
        }

        return back()->withErrors(['email' => 'Thông tin đăng nhập không hợp lệ.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
