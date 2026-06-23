<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'check_role:admin'])
    ->name('admin.dashboard');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('admin.dashboard.data');

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
});
