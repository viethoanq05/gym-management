@extends('layouts.admin')

@section('title', 'Tạo gói tập')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-semibold">Tạo gói tập</h2>

    <form action="{{ route('admin.packages.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Tên gói</label>
                <input name="name" value="{{ old('name') }}" class="mt-1 w-full border rounded px-3 py-2" />
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Giá tiền</label>
                <input name="price" value="{{ old('price') }}" class="mt-1 w-full border rounded px-3 py-2" />
                @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Thời hạn (ngày)</label>
                <input name="duration_days" value="{{ old('duration_days') }}" class="mt-1 w-full border rounded px-3 py-2" />
                @error('duration_days')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Trạng thái</label>
                <select name="status" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium">Mô tả</label>
                <textarea name="description" class="mt-1 w-full border rounded px-3 py-2" rows="4">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.packages.index') }}" class="px-4 py-2 border rounded">Huỷ</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Tạo</button>
        </div>
    </form>
</div>
@endsection