@extends('layouts.admin')

@section('title', 'Tạo gói tập')

@section('content')
<div class="space-y-6">
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <a href="{{ route('admin.packages.index') }}">Gói tập</a>
            <span class="separator">/</span>
            <span class="text-slate-300">Tạo mới</span>
        </div>
        <h2 class="page-title">Tạo gói tập</h2>
        <p class="page-subtitle">Thêm gói tập mới vào hệ thống</p>
    </div>

    <form action="{{ route('admin.packages.store') }}" method="POST" class="glass-card p-6 space-y-8 animate-fade-in-up">
        @csrf

        <div class="section-divider">
            <h3>Thông tin gói tập</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="admin-label">Tên gói</label>
                <input name="name" value="{{ old('name') }}" class="admin-input @error('name') input-error @enderror" placeholder="Nhập tên gói tập" />
                @error('name') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Giá tiền</label>
                <input name="price" value="{{ old('price') }}" class="admin-input @error('price') input-error @enderror" placeholder="Nhập giá tiền" />
                @error('price') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Thời hạn (ngày)</label>
                <input name="duration_days" value="{{ old('duration_days') }}" class="admin-input @error('duration_days') input-error @enderror" placeholder="Nhập số ngày" />
                @error('duration_days') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Trạng thái</label>
                <select name="status" class="admin-input admin-select @error('status') input-error @enderror">
                    <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="admin-label">Mô tả</label>
                <textarea name="description" class="admin-input @error('description') input-error @enderror" rows="4" placeholder="Nhập mô tả gói tập">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('admin.packages.index') }}" class="btn-secondary">Huỷ</a>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Tạo
            </button>
        </div>
    </form>
</div>
@endsection