@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Danh sách hội viên</h2>
                <a href="{{ route('trainer.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    @if($members->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Chưa có hội viên nào
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tên hội viên</th>
                                    <th>Giới tính</th>
                                    <th>Năm sinh</th>
                                    <th>Chiều cao (cm)</th>
                                    <th>Cân nặng (kg)</th>
                                    <th>Ngày tham gia</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                    <tr>
                                        <td>
                                            <strong>{{ $member->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $member->user->email }}</small>
                                        </td>
                                        <td>
                                            @if($member->gender == 'male')
                                                <span class="badge bg-primary">Nam</span>
                                            @else
                                                <span class="badge bg-danger">Nữ</span>
                                            @endif
                                        </td>
                                        <td>{{ $member->dob->format('d/m/Y') }}</td>
                                        <td>{{ number_format($member->height, 1) }}</td>
                                        <td>{{ number_format($member->weight, 1) }}</td>
                                        <td>{{ $member->join_date->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('trainer.members.show', $member->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Xem chi tiết
                                            </a>
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
                {{ $members->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
