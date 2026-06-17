@extends('layouts.admin')

@section('title', 'Tạo hội viên')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-semibold">Tạo hội viên</h2>

    <form action="{{ route('admin.members.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
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
            <h3 class="font-medium">Thông tin thể chất</h3>
            <div class="mt-3 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm">Giới tính</label>
                    <select name="gender" class="mt-1 w-full border rounded px-3 py-2 @error('gender') border-red-500 bg-rose-50 @enderror">
                        <option value="">-- Chọn --</option>
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                    @error('gender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">Ngày sinh</label>
                    <input name="dob" type="date" value="{{ old('dob') }}" class="mt-1 w-full border rounded px-3 py-2 @error('dob') border-red-500 bg-rose-50 @enderror" />
                    @error('dob') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">Ngày gia nhập</label>
                    <input name="join_date" type="date" value="{{ old('join_date') }}" class="mt-1 w-full border rounded px-3 py-2 @error('join_date') border-red-500 bg-rose-50 @enderror" />
                    @error('join_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">Chiều cao (cm)</label>
                    <input name="height" value="{{ old('height') }}" class="mt-1 w-full border rounded px-3 py-2 @error('height') border-red-500 bg-rose-50 @enderror" />
                    @error('height') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">Cân nặng (kg)</label>
                    <input name="weight" value="{{ old('weight') }}" class="mt-1 w-full border rounded px-3 py-2 @error('weight') border-red-500 bg-rose-50 @enderror" />
                    @error('weight') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.members.index') }}" class="px-4 py-2 border rounded">Huỷ</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Tạo</button>
        </div>
    </form>
</div>

@endsection