<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\MemberAuthController;
use App\Http\Controllers\Member\MemberBookingController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Member\MemberMembershipController;
use App\Http\Controllers\Member\MemberProfileController;

Route::get('/', [HomeController::class, 'index']);

// Authentication routes (simple custom handlers)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('member')->name('member.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/register', [MemberAuthController::class, 'showRegisterForm'])->name('register.form');
        Route::post('/register', [MemberAuthController::class, 'register'])->name('register.store');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});


Route::middleware(['auth', 'role:trainer'])->group(function () {
    Route::get('/trainer/dashboard', function () {
        return view('trainer.dashboard');
    })->name('trainer.dashboard');
});

Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');

    Route::get('/member/packages', [MemberMembershipController::class, 'packages'])->name('member.packages');
    Route::get('/member/memberships/history', [MemberMembershipController::class, 'history'])->name('member.memberships.history');
    Route::post('/member/memberships/subscribe', [MemberMembershipController::class, 'subscribe'])->name('member.memberships.subscribe');
    Route::patch('/member/memberships/{membershipId}/cancel', [MemberMembershipController::class, 'cancel'])->name('member.memberships.cancel');

    Route::get('/member/bookings', [MemberBookingController::class, 'index'])->name('member.bookings.index');
    Route::get('/member/bookings/create', [MemberBookingController::class, 'create'])->name('member.bookings.create');
    Route::get('/member/bookings/trainer-availability', [MemberBookingController::class, 'getTrainerAvailability'])->name('member.bookings.trainer-availability');
    Route::post('/member/bookings', [MemberBookingController::class, 'store'])->name('member.bookings.store');
    Route::patch('/member/bookings/{bookingId}/cancel', [MemberBookingController::class, 'cancel'])->name('member.bookings.cancel');

    Route::put('/member/profile', [MemberProfileController::class, 'update'])->name('member.profile.update');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');
});
