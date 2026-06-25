@extends('layouts.admin')

@section('title', 'Tạo hội viên')

@section('content')
<div class="space-y-6">
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <a href="{{ route('admin.members.index') }}">Hội viên</a>
            <span class="separator">/</span>
            <span class="text-slate-300">Tạo mới</span>
        </div>
        <h2 class="page-title">Tạo hội viên</h2>
        <p class="page-subtitle">Thêm hội viên mới vào hệ thống</p>
    </div>

    <form action="{{ route('admin.members.store') }}" method="POST" class="glass-card p-6 space-y-8 animate-fade-in-up">
        @csrf

        <div class="section-divider">
            <h3>Thông tin tài khoản</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="admin-label">Tên</label>
                <input name="name" value="{{ old('name') }}" class="admin-input @error('name') input-error @enderror" placeholder="Nhập họ và tên" />
                @error('name') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Email</label>
                <input name="email" value="{{ old('email') }}" class="admin-input @error('email') input-error @enderror" placeholder="Nhập email" />
                @error('email') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">SĐT</label>
                <input name="phone" value="{{ old('phone') }}" class="admin-input @error('phone') input-error @enderror" placeholder="Nhập số điện thoại" />
                @error('phone') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Mật khẩu</label>
                <input name="password" type="password" class="admin-input @error('password') input-error @enderror" placeholder="Nhập mật khẩu" />
                @error('password') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Xác nhận mật khẩu</label>
                <input name="password_confirmation" type="password" class="admin-input @error('password_confirmation') input-error @enderror" placeholder="Xác nhận mật khẩu" />
                @error('password_confirmation') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="section-divider">
            <h3>Thông tin thể chất</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="admin-label">Giới tính</label>
                <select name="gender" class="admin-input admin-select @error('gender') input-error @enderror">
                    <option value="">-- Chọn --</option>
                    <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Nam</option>
                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Nữ</option>
                    <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Khác</option>
                </select>
                @error('gender') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Ngày sinh</label>
                <input name="dob" type="date" value="{{ old('dob') }}" class="admin-input @error('dob') input-error @enderror" />
                @error('dob') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Ngày gia nhập</label>
                <input name="join_date" type="date" value="{{ old('join_date') }}" class="admin-input @error('join_date') input-error @enderror" />
                @error('join_date') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Chiều cao (cm)</label>
                <input name="height" value="{{ old('height') }}" class="admin-input @error('height') input-error @enderror" placeholder="VD: 170" />
                @error('height') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Cân nặng (kg)</label>
                <input name="weight" value="{{ old('weight') }}" class="admin-input @error('weight') input-error @enderror" placeholder="VD: 65" />
                @error('weight') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('admin.members.index') }}" class="btn-secondary">Huỷ</a>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Tạo
            </button>
        </div>
    </form>
</div>
@endsection