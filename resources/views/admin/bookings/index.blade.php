@extends('layouts.admin')

@section('title', 'Danh sách đặt lịch')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Đặt lịch</h2>
        <a href="{{ route('admin.bookings.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-md text-sm">Thêm đặt lịch</a>
    </div>

    <div class="rounded-2xl bg-white p-4 shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-xs text-slate-500">
                    <tr>
                        <th class="text-left py-2">Hội viên</th>
                        <th class="text-left py-2">PT</th>
                        <th class="text-left py-2">Ngày tập</th>
                        <th class="text-left py-2">Khung giờ</th>
                        <th class="text-left py-2">Trạng thái</th>
                        <th class="text-left py-2">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($bookings as $booking)
                    <tr class="border-t">
                        <td class="py-3">{{ optional($booking->member->user)->name }}</td>
                        <td class="py-3">{{ optional($booking->trainer->user)->name }}</td>
                        <td class="py-3">{{ $booking->booking_date }}</td>
                        <td class="py-3">{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                        <td class="py-3">
                            @if($booking->status === 1)
                            <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs text-sky-700">Đã xác nhận</span>
                            @elseif($booking->status === 2)
                            <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs text-amber-700">Chờ duyệt</span>
                            @else
                            <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs text-rose-700">Đã hủy</span>
                            @endif
                        </td>
                        <td class="py-3">
                            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="text-sm text-blue-600 mr-3">Sửa</a>
                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bản ghi này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-slate-500">Không có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $bookings->links() }}</div>
    </div>
</div>
@endsection