@extends('layouts.admin')

@section('title', 'Chỉnh sửa trainer')

@section('content')
<div class="space-y-6">
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <a href="{{ route('admin.trainers.index') }}">Huấn luyện viên</a>
            <span class="separator">/</span>
            <span class="text-slate-300">Chỉnh sửa</span>
        </div>
        <h2 class="page-title">Chỉnh sửa trainer</h2>
        <p class="page-subtitle">Cập nhật thông tin huấn luyện viên</p>
    </div>

    <form id="trainer-form" action="{{ route('admin.trainers.update', $user->id) }}" method="POST" class="glass-card p-6 space-y-8 animate-fade-in-up">
        @csrf
        @method('PUT')

        <div class="section-divider">
            <h3>Thông tin tài khoản</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="admin-label">Tên</label>
                <input name="name" value="{{ old('name', $user->name) }}" class="admin-input @error('name') input-error @enderror" placeholder="Nhập họ và tên" />
                @error('name') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Email</label>
                <input name="email" value="{{ old('email', $user->email) }}" class="admin-input @error('email') input-error @enderror" placeholder="Nhập email" />
                @error('email') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">SĐT</label>
                <input name="phone" value="{{ old('phone', $user->phone) }}" class="admin-input @error('phone') input-error @enderror" placeholder="Nhập số điện thoại" />
                @error('phone') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Mật khẩu (để trống nếu không đổi)</label>
                <input name="password" type="password" class="admin-input @error('password') input-error @enderror" placeholder="Nhập mật khẩu mới" />
                @error('password') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Xác nhận mật khẩu</label>
                <input name="password_confirmation" type="password" class="admin-input @error('password_confirmation') input-error @enderror" placeholder="Xác nhận mật khẩu" />
                @error('password_confirmation') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="section-divider">
            <h3>Thông tin chuyên môn</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="admin-label">Chuyên môn</label>
                <input name="specialization" value="{{ old('specialization', optional($user->trainer)->specialization) }}" class="admin-input @error('specialization') input-error @enderror" placeholder="VD: Yoga, Gym, Cardio..." />
                @error('specialization') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Kinh nghiệm (năm)</label>
                <input name="experience_years" value="{{ old('experience_years', optional($user->trainer)->experience_years) }}" class="admin-input @error('experience_years') input-error @enderror" placeholder="VD: 5" />
                @error('experience_years') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="admin-label">Mô tả</label>
                <textarea name="description" class="admin-input @error('description') input-error @enderror" rows="4" placeholder="Nhập mô tả về huấn luyện viên">{{ old('description', optional($user->trainer)->description) }}</textarea>
                @error('description') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('admin.trainers.index') }}" class="btn-secondary">Huỷ</a>
            <button id="save-btn" type="button" class="btn-primary">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Lưu thay đổi
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.getElementById('save-btn').addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn cập nhật?')) {
                document.getElementById('trainer-form').submit();
            }
        });
    </script>
    @endpush
</div>
@endsection