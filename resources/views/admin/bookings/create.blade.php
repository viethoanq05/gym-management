@extends('layouts.admin')

@section('title', 'Tạo đặt lịch')

@section('content')
<div class="space-y-6">
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <a href="{{ route('admin.bookings.index') }}">Đặt lịch</a>
            <span class="separator">/</span>
            <span class="text-slate-300">Tạo mới</span>
        </div>
        <h2 class="page-title">Tạo đặt lịch</h2>
        <p class="page-subtitle">Tạo lịch tập mới cho hội viên</p>
    </div>

    <form action="{{ route('admin.bookings.store') }}" method="POST" class="glass-card p-6 space-y-8 animate-fade-in-up">
        @csrf

        <div class="section-divider">
            <h3>Thông tin đặt lịch</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="admin-label">Hội viên</label>
                <select name="member_id" class="admin-input admin-select @error('member_id') input-error @enderror">
                    <option value="">Chọn hội viên</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ optional($member->user)->name }}</option>
                    @endforeach
                </select>
                @error('member_id') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Huấn luyện viên</label>
                <select name="trainer_id" class="admin-input admin-select @error('trainer_id') input-error @enderror">
                    <option value="">Chọn PT</option>
                    @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>{{ optional($trainer->user)->name }}</option>
                    @endforeach
                </select>
                @error('trainer_id') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Ngày tập</label>
                <input name="booking_date" type="date" value="{{ old('booking_date') }}" class="admin-input @error('booking_date') input-error @enderror" />
                @error('booking_date') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Bắt đầu</label>
                <input name="start_time" type="time" value="{{ old('start_time') }}" class="admin-input @error('start_time') input-error @enderror" />
                @error('start_time') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Kết thúc</label>
                <input name="end_time" type="time" value="{{ old('end_time') }}" class="admin-input @error('end_time') input-error @enderror" />
                @error('end_time') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Trạng thái</label>
                <select name="status" class="admin-input admin-select @error('status') input-error @enderror">
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Đã xác nhận</option>
                    <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Đã hủy</option>
                </select>
                @error('status') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('admin.bookings.index') }}" class="btn-secondary">Huỷ</a>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Tạo
            </button>
        </div>
    </form>
</div>
@endsection