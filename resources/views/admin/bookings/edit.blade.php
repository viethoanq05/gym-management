@extends('layouts.admin')

@section('title', 'Chỉnh sửa đặt lịch')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-semibold">Chỉnh sửa đặt lịch</h2>

    <form id="booking-form" action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Hội viên</label>
                <select name="member_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">Chọn hội viên</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id', $booking->member_id) == $member->id ? 'selected' : '' }}>{{ optional($member->user)->name }}</option>
                    @endforeach
                </select>
                @error('member_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Huấn luyện viên</label>
                <select name="trainer_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">Chọn PT</option>
                    @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}" {{ old('trainer_id', $booking->trainer_id) == $trainer->id ? 'selected' : '' }}>{{ optional($trainer->user)->name }}</option>
                    @endforeach
                </select>
                @error('trainer_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Ngày tập</label>
                <input name="booking_date" type="date" value="{{ old('booking_date', $booking->booking_date) }}" class="mt-1 w-full border rounded px-3 py-2" />
                @error('booking_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Bắt đầu</label>
                <input name="start_time" type="time" value="{{ old('start_time', $booking->start_time) }}" class="mt-1 w-full border rounded px-3 py-2" />
                @error('start_time')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Kết thúc</label>
                <input name="end_time" type="time" value="{{ old('end_time', $booking->end_time) }}" class="mt-1 w-full border rounded px-3 py-2" />
                @error('end_time')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Trạng thái</label>
                <select name="status" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="1" {{ old('status', $booking->status) == 1 ? 'selected' : '' }}>Đã xác nhận</option>
                    <option value="2" {{ old('status', $booking->status) == 2 ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="0" {{ old('status', $booking->status) == 0 ? 'selected' : '' }}>Đã hủy</option>
                </select>
                @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 border rounded">Huỷ</a>
            <button id="save-btn" type="button" class="px-4 py-2 bg-blue-600 text-white rounded">Lưu thay đổi</button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.getElementById('save-btn').addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn cập nhật?')) {
                document.getElementById('booking-form').submit();
            }
        });
    </script>
    @endpush
</div>
@endsection