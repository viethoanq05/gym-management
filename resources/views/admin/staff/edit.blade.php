@extends('layouts.admin')

@section('title', 'Chỉnh sửa nhân viên')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-semibold">Chỉnh sửa nhân viên</h2>

    <form id="staff-form" action="{{ route('admin.staff.update', $user->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm">Tên</label>
                <input name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full border rounded px-3 py-2 @error('name') border-red-500 bg-rose-50 @enderror" />
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm">Email</label>
                <input name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full border rounded px-3 py-2 @error('email') border-red-500 bg-rose-50 @enderror" />
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm">SĐT</label>
                <input name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full border rounded px-3 py-2 @error('phone') border-red-500 bg-rose-50 @enderror" />
                @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm">Mật khẩu (để trống nếu không đổi)</label>
                <input name="password" type="password" class="mt-1 w-full border rounded px-3 py-2 @error('password') border-red-500 bg-rose-50 @enderror" />
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm">Xác nhận mật khẩu</label>
                <input name="password_confirmation" type="password" class="mt-1 w-full border rounded px-3 py-2 @error('password_confirmation') border-red-500 bg-rose-50 @enderror" />
                @error('password_confirmation') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.staff.index') }}" class="px-4 py-2 border rounded">Huỷ</a>
            <button id="save-btn" type="button" class="px-4 py-2 bg-blue-600 text-white rounded">Lưu thay đổi</button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.getElementById('save-btn').addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn cập nhật?')) {
                document.getElementById('staff-form').submit();
            }
        });
    </script>
    @endpush
</div>

@endsection