@extends('layouts.admin')

@section('title', 'Tạo nhân viên')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-semibold">Tạo nhân viên</h2>

    <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf
        <div class="grid grid-cols-2 gap-4">
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

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.staff.index') }}" class="px-4 py-2 border rounded">Huỷ</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Tạo</button>
        </div>
    </form>
</div>

@endsection