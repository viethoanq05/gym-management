@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Thông tin thể trạng - {{ $member->user->name }}</h2>
                <a href="{{ route('trainer.members.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    <!-- Thông tin cơ bản -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p><strong>Tên:</strong></p>
                            <p>{{ $member->user->name }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Email:</strong></p>
                            <p>{{ $member->user->email }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Điện thoại:</strong></p>
                            <p>{{ $member->user->phone }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Giới tính:</strong></p>
                            <p>
                                @if($member->gender == 'male')
                                    <span class="badge bg-primary">Nam</span>
                                @else
                                    <span class="badge bg-danger">Nữ</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chỉ số sức khỏe -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Chiều cao</h6>
                    <h3>{{ number_format($member->height, 1) }} cm</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Cân nặng</h6>
                    <h3>{{ number_format($member->weight, 1) }} kg</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card @if($bmi < 18.5) bg-success @elseif($bmi < 25) bg-primary @elseif($bmi < 30) bg-warning @else bg-danger @endif text-white">
                <div class="card-body">
                    <h6 class="card-title">BMI</h6>
                    <h3>{{ $bmi }}</h3>
                    <small>
                        @if($bmi < 18.5)
                            Thiếu cân
                        @elseif($bmi < 25)
                            Bình thường
                        @elseif($bmi < 30)
                            Thừa cân
                        @else
                            Béo phì
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê tham gia -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Lần check-in gần nhất</h6>
                    @if($lastCheckIn)
                        <p class="mb-2">
                            <strong>{{ $lastCheckIn->checkin_time->format('d/m/Y H:i') }}</strong>
                        </p>
                        @if($lastCheckIn->checkout_time)
                            <p class="text-muted mb-0">Check-out: {{ $lastCheckIn->checkout_time->format('d/m/Y H:i') }}</p>
                        @else
                            <p class="text-danger mb-0"><i class="fas fa-exclamation-circle"></i> Chưa check-out</p>
                        @endif
                    @else
                        <p class="text-muted">Chưa có check-in nào</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Thống kê tháng này</h6>
                    <p class="mb-0">
                        <strong>{{ $checkinsThisMonth }}</strong> lần check-in
                        <br>
                        <small class="text-muted">Tháng {{ now()->format('m/Y') }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lịch sử check-in -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Lịch sử check-in</h5>
                </div>
                <div class="card-body">
                    @if($checkinHistory->isEmpty())
                        <p class="text-muted mb-0">Không có lịch sử check-in</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Thời lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($checkinHistory as $checkin)
                                        <tr>
                                            <td>{{ $checkin->checkin_time->format('d/m/Y') }}</td>
                                            <td>{{ $checkin->checkin_time->format('H:i') }}</td>
                                            <td>
                                                @if($checkin->checkout_time)
                                                    {{ $checkin->checkout_time->format('H:i') }}
                                                @else
                                                    <span class="badge bg-warning">Đang tập</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($checkin->checkout_time)
                                                    @php
                                                        $duration = $checkin->checkout_time->diffInMinutes($checkin->checkin_time);
                                                        $hours = floor($duration / 60);
                                                        $minutes = $duration % 60;
                                                    @endphp
                                                    {{ $hours }}h {{ $minutes }}m
                                                @else
                                                    -
                                                @endif
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

    <!-- Pagination -->
    @if(!$checkinHistory->isEmpty())
        <div class="row mt-4">
            <div class="col-md-12">
                {{ $checkinHistory->links() }}
            </div>
        </div>
    @endif
</div>

<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: none;
    }
</style>
@endsection
