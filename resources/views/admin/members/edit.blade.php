@extends('layouts.admin')

@section('title', 'Chỉnh sửa hội viên')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-slate-900">Chỉnh sửa hội viên</h2>
    </div>

    <form id="member-form" action="{{ route('admin.members.update', $user->id) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-5">
                <h3 class="text-lg font-medium text-slate-900 border-b pb-2">Thông tin tài khoản</h3>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Họ và tên <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full border rounded-xl px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm @error('name') border-red-500 bg-red-50 @enderror" />
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Số điện thoại <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full border rounded-xl px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm @error('phone') border-red-500 bg-red-50 @enderror" />
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full border rounded-xl px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm @error('email') border-red-500 bg-red-50 @enderror" />
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Mật khẩu mới <span class="text-slate-400 font-normal">(Để trống nếu không đổi)</span></label>
                    <input type="password" name="password" class="mt-1 w-full border rounded-xl px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm @error('password') border-red-500 bg-red-50 @enderror" autocomplete="new-password" />
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-5">
                <h3 class="text-lg font-medium text-slate-900 border-b pb-2">Thông tin thể chất</h3>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Giới tính</label>
                    <select name="gender" class="mt-1 w-full border rounded-xl px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm bg-white @error('gender') border-red-500 bg-red-50 @enderror">
                        <option value="">-- Chọn giới tính --</option>
                        <option value="male" {{ old('gender', optional($user->member)->gender) === 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender', optional($user->member)->gender) === 'female' ? 'selected' : '' }}>Nữ</option>
                    </select>
                    @error('gender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Ngày sinh</label>
                    <input type="date" name="dob" value="{{ old('dob', optional($user->member)->dob ? optional($user->member)->dob->format('Y-m-d') : '') }}" class="mt-1 w-full border rounded-xl px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm @error('dob') border-red-500 bg-red-50 @enderror" />
                    @error('dob') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Chiều cao (cm)</label>
                        <input type="number" step="0.1" name="height" value="{{ old('height', optional($user->member)->height) }}" class="mt-1 w-full border rounded-xl px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm @error('height') border-red-500 bg-red-50 @enderror" />
                        @error('height') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Cân nặng (kg)</label>
                        <input type="number" step="0.1" name="weight" value="{{ old('weight', optional($user->member)->weight) }}" class="mt-1 w-full border rounded-xl px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm @error('weight') border-red-500 bg-red-50 @enderror" />
                        @error('weight') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Ngày tham gia</label>
                    <input type="date" name="join_date" value="{{ old('join_date', optional($user->member)->join_date ? optional($user->member)->join_date->format('Y-m-d') : '') }}" class="mt-1 w-full border rounded-xl px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm @error('join_date') border-red-500 bg-red-50 @enderror" />
                    @error('join_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 mt-8 pt-5 border-t border-slate-100">
            <a href="{{ route('admin.members.index') }}" class="px-5 py-2.5 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 font-medium transition shadow-sm">Hủy bỏ</a>
            <button id="save-btn" type="button" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-medium transition shadow-sm">Lưu thay đổi</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('save-btn').addEventListener('click', function() {
        if (confirm('Bạn có chắc chắn muốn lưu các thay đổi này?')) {
            document.getElementById('member-form').submit();
        }
    });
</script>
@endpush
@endsection