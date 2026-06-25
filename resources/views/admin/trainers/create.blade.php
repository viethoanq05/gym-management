@extends('layouts.admin')

@section('title', 'Tạo trainer')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-semibold">Tạo trainer</h2>

    <form action="{{ route('admin.trainers.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf
        <div>
            <h3 class="font-medium">Thông tin tài khoản</h3>
            <div class="mt-3 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm">Tên</label>
                    <input name="name" value="{{ old('name') }}" class="mt-1 w-full border rounded px-3 py-2 @error('name') border-red-500 bg-rose-50 @enderror" />
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">Email</label>
                    <input name="email" value="{{ old('email') }}" class="mt-1 w-full border rounded px-3 py-2 @error('email') border-red-500 bg-rose-50 @enderror" />
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">SĐT</label>
                    <input name="phone" value="{{ old('phone') }}" class="mt-1 w-full border rounded px-3 py-2 @error('phone') border-red-500 bg-rose-50 @enderror" />
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">Mật khẩu</label>
                    <input name="password" type="password" class="mt-1 w-full border rounded px-3 py-2 @error('password') border-red-500 bg-rose-50 @enderror" />
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">Xác nhận mật khẩu</label>
                    <input name="password_confirmation" type="password" class="mt-1 w-full border rounded px-3 py-2 @error('password_confirmation') border-red-500 bg-rose-50 @enderror" />
                    @error('password_confirmation') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-medium">Thông tin chuyên môn</h3>
            <div class="mt-3 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm">Chuyên môn</label>
                    <input name="specialization" value="{{ old('specialization') }}" class="mt-1 w-full border rounded px-3 py-2 @error('specialization') border-red-500 bg-rose-50 @enderror" />
                    @error('specialization') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">Kinh nghiệm (năm)</label>
                    <input name="experience_years" value="{{ old('experience_years') }}" class="mt-1 w-full border rounded px-3 py-2 @error('experience_years') border-red-500 bg-rose-50 @enderror" />
                    @error('experience_years') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="col-span-2">
                    <label class="block text-sm">Mô tả</label>
                    <textarea name="description" class="mt-1 w-full border rounded px-3 py-2 @error('description') border-red-500 bg-rose-50 @enderror">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.trainers.index') }}" class="px-4 py-2 border rounded">Huỷ</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Tạo</button>
        </div>
    </form>
</div>

@endsection