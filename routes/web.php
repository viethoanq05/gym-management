<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Trainer\DashboardController;
use App\Http\Controllers\Trainer\ScheduleController;
use App\Http\Controllers\Trainer\MemberStatusController;

Route::get('/', [HomeController::class, 'index']);

// Authentication routes (simple custom handlers)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});


Route::middleware(['auth', 'role:trainer'])->group(function () {
    // Dashboard
    Route::get('/trainer/dashboard', [DashboardController::class, 'index'])->name('trainer.dashboard');

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
    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    })->name('member.dashboard');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');
});
