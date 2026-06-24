<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\MemberAuthController;
use App\Http\Controllers\Member\MemberBookingController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Member\MemberMembershipController;
use App\Http\Controllers\Member\MemberProfileController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboardController;
use App\Http\Controllers\Trainer\ScheduleController;
use App\Http\Controllers\Trainer\MemberStatusController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', [HomeController::class, 'index']);

// Authentication routes (simple custom handlers)


Route::get('/', [HomeController::class, 'index']);

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'check_role:admin'])
    ->name('admin.dashboard');



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
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/data', [AdminDashboardController::class, 'getDashboardData'])->name('admin.dashboard.data');

    // Admin resources for members, staff, trainers
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('members', App\Http\Controllers\Admin\MemberController::class);
        Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
        Route::resource('trainers', App\Http\Controllers\Admin\TrainerController::class);
        Route::resource('packages', App\Http\Controllers\Admin\PackageController::class);
        Route::get('reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
        Route::resource('bookings', App\Http\Controllers\Admin\BookingController::class);
        Route::resource('payments', App\Http\Controllers\Admin\PaymentController::class);
    });
});

Route::middleware(['auth', 'role:trainer'])->group(function () {
    // Dashboard
    Route::get('/trainer/dashboard', [TrainerDashboardController::class, 'index'])->name('trainer.dashboard');

    // Lịch làm việc
    Route::prefix('/trainer/schedule')->name('trainer.schedule.')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('index');
        Route::get('/bookings', [ScheduleController::class, 'bookings'])->name('bookings');
        Route::post('/accept/{booking}', [ScheduleController::class, 'acceptBooking'])->name('accept');
        Route::post('/cancel/{booking}', [ScheduleController::class, 'cancelBooking'])->name('cancel');
    });

    // Theo dõi thể trạng hội viên
    Route::prefix('/trainer/members')->name('trainer.members.')->group(function () {
        Route::get('/', [MemberStatusController::class, 'index'])->name('index');
        Route::get('/{member}', [MemberStatusController::class, 'show'])->name('show');
        Route::post('/{member}/note', [MemberStatusController::class, 'addNote'])->name('addNote');
    });
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
    Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');
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