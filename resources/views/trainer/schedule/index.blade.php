@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Lịch làm việc</h2>
                <a href="{{ route('trainer.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    @if($schedules->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Không có lịch làm việc trong tương lai
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
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th>Thời lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $schedule)
                                    <tr>
                                        <td>
                                            <strong>{{ $schedule->work_date->format('d/m/Y') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $schedule->work_date->isoFormat('dddd') }}</small>
                                        </td>
                                        <td>{{ $schedule->start_time }}</td>
                                        <td>{{ $schedule->end_time }}</td>
                                        <td>
                                            @php
                                                $start = strtotime($schedule->start_time);
                                                $end = strtotime($schedule->end_time);
                                                $hours = round(($end - $start) / 3600, 1);
                                            @endphp
                                            {{ $hours }} giờ
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
                {{ $schedules->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
