@extends('layouts.admin')

@section('title', 'Chỉnh sửa trainer')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-semibold">Chỉnh sửa trainer</h2>

    <form id="trainer-form" action="{{ route('admin.trainers.update', $user->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
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
                    <input name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">SĐT</label>
                    <input name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">Mật khẩu (để trống nếu không đổi)</label>
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
                    <input name="specialization" value="{{ old('specialization', optional($user->trainer)->specialization) }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm">Kinh nghiệm (năm)</label>
                    <input name="experience_years" value="{{ old('experience_years', optional($user->trainer)->experience_years) }}" class="mt-1 w-full border rounded px-3 py-2" />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm">Mô tả</label>
                    <textarea name="description" class="mt-1 w-full border rounded px-3 py-2">{{ old('description', optional($user->trainer)->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.trainers.index') }}" class="px-4 py-2 border rounded">Huỷ</a>
            <button id="save-btn" type="button" class="px-4 py-2 bg-blue-600 text-white rounded">Lưu thay đổi</button>
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