@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-4">Dashboard - Huấn Luyện Viên</h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Số giờ dạy -->
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Số giờ dạy</h6>
                            <h2 class="mb-0">{{ $totalTeachingHours }}</h2>
                            <small>giờ</small>
                        </div>
                        <div style="font-size: 2.5rem; opacity: 0.5;">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Điểm cộng -->
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Điểm cộng</h6>
                            <h2 class="mb-0">+{{ $bonusPoints }}</h2>
                            <small>điểm</small>
                        </div>
                        <div style="font-size: 2.5rem; opacity: 0.5;">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Điểm trừ -->
        <div class="col-md-4 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Điểm trừ</h6>
                            <h2 class="mb-0">-{{ $penaltyPoints }}</h2>
                            <small>điểm</small>
                        </div>
                        <div style="font-size: 2.5rem; opacity: 0.5;">
                            <i class="fas fa-minus-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Points Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Tổng điểm</h5>
                            <h3 class="@if($totalPoints >= 0) text-success @else text-danger @endif">
                                @if($totalPoints >= 0) + @endif{{ $totalPoints }}
                            </h3>
                        </div>
                        <div style="font-size: 3rem; opacity: 0.3;">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Schedules -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Lịch sắp tới (7 ngày)</h5>
                </div>
                <div class="card-body">
                    @if($upcomingSchedules->isEmpty())
                        <p class="text-muted mb-0">Không có lịch sắp tới</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Thời gian</th>
                                        <th>Hội viên</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingSchedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->booking_date->format('d/m/Y') }}</td>
                                            <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                            <td>{{ $schedule->member->user->name }}</td>
                                            <td>
                                                @if($schedule->status == 1)
                                                    <span class="badge bg-success">Đã xác nhận</span>
                                                @elseif($schedule->status == 0)
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                @else
                                                    <span class="badge bg-warning">Chờ xác nhận</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('trainer.schedule.bookings') }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Xem chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title mb-3">Liên kết nhanh</h5>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('trainer.schedule.bookings') }}" class="btn btn-outline-primary btn-block w-100">
                                <i class="fas fa-calendar-check"></i> Xem lịch đặt
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('trainer.members.index') }}" class="btn btn-outline-primary btn-block w-100">
                                <i class="fas fa-users"></i> Danh sách hội viên
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('trainer.schedule.index') }}" class="btn btn-outline-primary btn-block w-100">
                                <i class="fas fa-clock"></i> Lịch làm việc
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-block w-100" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-block {
        display: block;
        width: 100%;
    }

    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: none;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
    }
</style>
@endsection
