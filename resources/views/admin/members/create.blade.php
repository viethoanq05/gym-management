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
            <h3 class="font-medium">Thông tin thể chất</h3>
            <div class="mt-3 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm">Giới tính</label>
                    <select name="gender" class="mt-1 w-full border rounded px-3 py-2">
                        <option value="">-- Chọn --</option>
                        <option value="male">Nam</option>
                        <option value="female">Nữ</option>
                        <option value="other">Khác</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm">Ngày sinh</label>
                    <input name="dob" type="date" value="{{ old('dob') }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">Ngày gia nhập</label>
                    <input name="join_date" type="date" value="{{ old('join_date') }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">Chiều cao (cm)</label>
                    <input name="height" value="{{ old('height') }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">Cân nặng (kg)</label>
                    <input name="weight" value="{{ old('weight') }}" class="mt-1 w-full border rounded px-3 py-2" />
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