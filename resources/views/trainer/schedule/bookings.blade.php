@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Lịch đặt của khách hàng</h2>
                <a href="{{ route('trainer.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($bookings->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Không có lịch đặt trong tương lai
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Ngày</th>
                                    <th>Thời gian</th>
                                    <th>Hội viên</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <strong>{{ $booking->booking_date->format('d/m/Y') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $booking->booking_date->isoFormat('dddd') }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $booking->start_time }}</strong> - {{ $booking->end_time }}
                                            <br>
                                            @php
                                                $start = strtotime($booking->start_time);
                                                $end = strtotime($booking->end_time);
                                                $hours = round(($end - $start) / 3600, 1);
                                            @endphp
                                            <small class="text-muted">{{ $hours }} giờ</small>
                                        </td>
                                        <td>
                                            {{ $booking->member->user->name }}
                                            <br>
                                            <small class="text-muted">{{ $booking->member->user->phone }}</small>
                                        </td>
                                        <td>
                                            @if($booking->status == 1)
                                                <span class="badge bg-success">✓ Đã xác nhận</span>
                                            @elseif($booking->status == 0)
                                                <span class="badge bg-danger">✗ Đã hủy</span>
                                            @else
                                                <span class="badge bg-warning">⏳ Chờ xác nhận</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->status == 2)
                                                <!-- Chưa xác nhận -->
                                                <form action="{{ route('trainer.schedule.accept', $booking->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Nhận lịch">
                                                        <i class="fas fa-check"></i> Nhận
                                                    </button>
                                                </form>
                                                <form action="{{ route('trainer.schedule.cancel', $booking->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hủy lịch" onclick="return confirm('Bạn chắc chắn muốn hủy lịch này?')">
                                                        <i class="fas fa-times"></i> Hủy
                                                    </button>
                                                </form>
                                            @elseif($booking->status == 1)
                                                <!-- Đã xác nhận -->
                                                <form action="{{ route('trainer.schedule.cancel', $booking->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning" title="Hủy lịch" onclick="return confirm('Bạn chắc chắn muốn hủy lịch này?')">
                                                        <i class="fas fa-times"></i> Hủy
                                                    </button>
                                                </form>
                                                <a href="{{ route('trainer.members.show', $booking->member_id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Xem thể trạng
                                                </a>
                                            @else
                                                <!-- Đã hủy -->
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-md-12">
                {{ $bookings->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
