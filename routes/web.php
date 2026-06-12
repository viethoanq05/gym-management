<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Route::view('/', 'home');

// Authentication routes (simple custom handlers)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});


Route::middleware(['auth', 'role:trainer'])->group(function () {
    Route::get('/trainer/dashboard', function () {
        return view('trainer.dashboard');
    });
});

Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    });
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    });
});
