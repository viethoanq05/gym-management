@extends('layouts.admin')

@section('title', 'Chỉnh sửa hội viên')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-semibold">Chỉnh sửa hội viên</h2>

    <form id="member-form" action="{{ route('admin.members.update', $user->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf
        @method('PUT')
        <div>
            <h3 class="font-medium">Thông tin tài khoản</h3>
            <div class="mt-3 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm">Tên</label>
                    <input name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">Email</label>
                    <input name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full border rounded px-3 py-2 @error('name') border-red-500 bg-rose-50 @enderror" />
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">SĐT</label>
                    <input name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full border rounded px-3 py-2 @error('email') border-red-500 bg-rose-50 @enderror" />
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">Mật khẩu (để trống nếu không đổi)</label>
                    <input name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full border rounded px-3 py-2 @error('phone') border-red-500 bg-rose-50 @enderror" />
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm">Xác nhận mật khẩu</label>
                    <input name="password" type="password" class="mt-1 w-full border rounded px-3 py-2 @error('password') border-red-500 bg-rose-50 @enderror" />
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        <input name="password_confirmation" type="password" class="mt-1 w-full border rounded px-3 py-2 @error('password_confirmation') border-red-500 bg-rose-50 @enderror" />
        @error('password_confirmation') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        <div>
            <h3 class="font-medium">Thông tin thể chất</h3>
            <div class="mt-3 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm">Giới tính</label>
                    <select name="gender" class="mt-1 w-full border rounded px-3 py-2">
                        <option value="">-- Chọn --</option>
                        <option value="male" {{ old('gender', optional($user->member)->gender) === 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender', optional($user->member)->gender) === 'female' ? 'selected' : '' }}>Nữ</option>
                        <select name="gender" class="mt-1 w-full border rounded px-3 py-2 @error('gender') border-red-500 bg-rose-50 @enderror">
                        </select>
                </div>
                <div>
                    </select>
                    @error('gender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    <input name="dob" type="date" value="{{ old('dob', optional($user->member)->dob) }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <input name="dob" type="date" value="{{ old('dob', optional($user->member)->dob) }}" class="mt-1 w-full border rounded px-3 py-2 @error('dob') border-red-500 bg-rose-50 @enderror" />
                    @error('dob') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    <input name="join_date" type="date" value="{{ old('join_date', optional($user->member)->join_date) }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <input name="join_date" type="date" value="{{ old('join_date', optional($user->member)->join_date) }}" class="mt-1 w-full border rounded px-3 py-2 @error('join_date') border-red-500 bg-rose-50 @enderror" />
                    @error('join_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    <input name="height" value="{{ old('height', optional($user->member)->height) }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <input name="height" value="{{ old('height', optional($user->member)->height) }}" class="mt-1 w-full border rounded px-3 py-2 @error('height') border-red-500 bg-rose-50 @enderror" />
                    @error('height') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    <input name="weight" value="{{ old('weight', optional($user->member)->weight) }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
            </div>
            <input name="weight" value="{{ old('weight', optional($user->member)->weight) }}" class="mt-1 w-full border rounded px-3 py-2 @error('weight') border-red-500 bg-rose-50 @enderror" />
            @error('weight') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.members.index') }}" class="px-4 py-2 border rounded">Huỷ</a>
                <button id="save-btn" type="button" class="px-4 py-2 bg-blue-600 text-white rounded">Lưu thay đổi</button>
            </div>
    </form>

    @push('scripts')
    <script>
        // Yêu cầu xác nhận trước khi submit form cập nhật
        document.getElementById('save-btn').addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn cập nhật?')) {
                document.getElementById('member-form').submit();
            }
        });
    </script>
    @endpush
</div>

@endsection