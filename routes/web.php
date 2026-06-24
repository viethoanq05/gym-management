<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Staff\StaffController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    })->name('member.dashboard');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    
    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');

    // --- MEMBER MANAGEMENT MODULE ---
    Route::get('/staff/members/create', [StaffController::class, 'createMember'])->name('staff.members.create');
    Route::post('/staff/members', [StaffController::class, 'storeMember'])->name('staff.members.store');

    // --- CHECK-IN / CHECK-OUT MODULE ---
    Route::get('/staff/check-in', [StaffController::class, 'showCheckIn'])->name('staff.checkin');
    Route::post('/staff/check-in/search', [StaffController::class, 'searchMember'])->name('staff.search');
    Route::post('/staff/check-in/{id}/confirm', [StaffController::class, 'storeCheckIn'])->name('staff.checkin.confirm');
    Route::post('/staff/check-in/{id}/out', [StaffController::class, 'checkoutMember'])->name('staff.checkin.out');

    // --- SCHEDULES MODULE ---
    Route::get('/staff/schedules', [StaffController::class, 'showSchedules'])->name('staff.schedules');
    Route::post('/staff/schedules/{id}/confirm', [StaffController::class, 'confirmSchedule'])->name('staff.schedules.confirm');

    // --- MEMBERSHIPS MODULE ---
    Route::get('/staff/memberships', [StaffController::class, 'showMemberships'])->name('staff.memberships');
    Route::get('/staff/memberships/assign', [StaffController::class, 'assignMembership'])->name('staff.memberships.assign');
    Route::post('/staff/memberships/assign', [StaffController::class, 'storeAssignedMembership'])->name('staff.memberships.assign.store');
    Route::post('/staff/memberships/{id}/confirm', [StaffController::class, 'confirmMembership'])->name('staff.memberships.confirm');
    Route::post('/staff/memberships/{id}/reject', [StaffController::class, 'rejectMembership'])->name('staff.memberships.reject');
    Route::post('/staff/memberships/{id}/freeze', [StaffController::class, 'freezeMembership'])->name('staff.memberships.freeze');
    Route::post('/staff/memberships/{id}/unfreeze', [StaffController::class, 'unfreezeMembership'])->name('staff.memberships.unfreeze');
    Route::post('/staff/memberships/{id}/cancel', [StaffController::class, 'cancelMembership'])->name('staff.memberships.cancel');
});