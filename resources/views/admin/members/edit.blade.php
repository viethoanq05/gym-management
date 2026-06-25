@extends('layouts.admin')

@section('title', 'Chỉnh sửa hội viên')

@section('content')
<div class="space-y-6">
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <a href="{{ route('admin.members.index') }}">Hội viên</a>
            <span class="separator">/</span>
            <span class="text-slate-300">Chỉnh sửa</span>
        </div>
        <h2 class="page-title">Chỉnh sửa hội viên</h2>
        <p class="page-subtitle">Cập nhật thông tin hội viên</p>
    </div>

    <form id="member-form" action="{{ route('admin.members.update', $user->id) }}" method="POST" class="glass-card p-6 space-y-8 animate-fade-in-up">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-5">
                <div class="section-divider">
                    <h3>Thông tin tài khoản</h3>
                </div>

                <div>
                    <label class="admin-label">Họ và tên <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="admin-input @error('name') input-error @enderror" placeholder="Nhập họ và tên" />
                    @error('name') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="admin-label">Số điện thoại <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="admin-input @error('phone') input-error @enderror" placeholder="Nhập số điện thoại" />
                    @error('phone') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="admin-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="admin-input @error('email') input-error @enderror" placeholder="Nhập email" />
                    @error('email') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="admin-label">Mật khẩu mới <span class="text-slate-500 font-normal">(Để trống nếu không đổi)</span></label>
                    <input type="password" name="password" class="admin-input @error('password') input-error @enderror" autocomplete="new-password" placeholder="Nhập mật khẩu mới" />
                    @error('password') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-5">
                <div class="section-divider">
                    <h3>Thông tin thể chất</h3>
                </div>

                <div>
                    <label class="admin-label">Giới tính</label>
                    <select name="gender" class="admin-input admin-select @error('gender') input-error @enderror">
                        <option value="">-- Chọn giới tính --</option>
                        <option value="male" {{ old('gender', optional($user->member)->gender) === 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender', optional($user->member)->gender) === 'female' ? 'selected' : '' }}>Nữ</option>
                    </select>
                    @error('gender') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="admin-label">Ngày sinh</label>
                    <input type="date" name="dob" value="{{ old('dob', optional($user->member)->dob ? optional($user->member)->dob->format('Y-m-d') : '') }}" class="admin-input @error('dob') input-error @enderror" />
                    @error('dob') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Chiều cao (cm)</label>
                        <input type="number" step="0.1" name="height" value="{{ old('height', optional($user->member)->height) }}" class="admin-input @error('height') input-error @enderror" placeholder="VD: 170" />
                        @error('height') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="admin-label">Cân nặng (kg)</label>
                        <input type="number" step="0.1" name="weight" value="{{ old('weight', optional($user->member)->weight) }}" class="admin-input @error('weight') input-error @enderror" placeholder="VD: 65" />
                        @error('weight') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="admin-label">Ngày tham gia</label>
                    <input type="date" name="join_date" value="{{ old('join_date', optional($user->member)->join_date ? optional($user->member)->join_date->format('Y-m-d') : '') }}" class="admin-input @error('join_date') input-error @enderror" />
                    @error('join_date') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('admin.members.index') }}" class="btn-secondary">Hủy bỏ</a>
            <button id="save-btn" type="button" class="btn-primary">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Lưu thay đổi
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('save-btn').addEventListener('click', function() {
        if (confirm('Bạn có chắc chắn muốn lưu các thay đổi này?')) {
            document.getElementById('member-form').submit();
        }
    });
</script>
@endpush
@endsection