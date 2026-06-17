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
                    <input name="name" value="{{ old('name') }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">Email</label>
                    <input name="email" value="{{ old('email') }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">SĐT</label>
                    <input name="phone" value="{{ old('phone') }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">Mật khẩu</label>
                    <input name="password" type="password" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">Xác nhận mật khẩu</label>
                    <input name="password_confirmation" type="password" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-medium">Thông tin chuyên môn</h3>
            <div class="mt-3 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm">Chuyên môn</label>
                    <input name="specialization" value="{{ old('specialization') }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">Kinh nghiệm (năm)</label>
                    <input name="experience_years" value="{{ old('experience_years') }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm">Mô tả</label>
                    <textarea name="description" class="mt-1 w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
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