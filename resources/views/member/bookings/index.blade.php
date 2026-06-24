@extends('member.layout')

@section('title', 'Lịch hẹn PT')
@section('header_title', 'Lịch hẹn tập luyện')

@section('content')

<!-- Header Banner -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Danh sách lịch hẹn PT</h1>
    </div>
    
    <div>
        <a href="{{ route('member.bookings.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-lg shadow-blue-500/20">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>Đặt lịch PT mới</span>
        </a>
    </div>
</div>

<!-- Bookings List Card -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 font-extrabold text-xs uppercase tracking-wider">
                    <th class="px-6 py-4">Huấn luyện viên (PT)</th>
                    <th class="px-6 py-4">Ngày hẹn</th>
                    <th class="px-6 py-4">Giờ tập</th>
                    <th class="px-6 py-4">Trạng thái</th>
                    <th class="px-6 py-4 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm font-semibold text-slate-600">
                @forelse($bookings as $booking)
                    @php
                        $dayNames = [
                            0 => 'Chủ Nhật',
                            1 => 'Thứ 2',
                            2 => 'Thứ 3',
                            3 => 'Thứ 4',
                            4 => 'Thứ 5',
                            5 => 'Thứ 6',
                            6 => 'Thứ 7'
                        ];
                        $bookingDate = \Carbon\Carbon::parse($booking->booking_date);
                        $dayName = $dayNames[$bookingDate->dayOfWeek];
                        $isUpcoming = $bookingDate->isAfter(now()->subDay()) && $booking->status != \App\Models\Booking::CANCELLED;
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->trainer->user->name) }}&background=1662ff&color=fff&bold=true" alt="PT Avatar" class="w-9 h-9 rounded-full object-cover">
                                <div>
                                    <div class="font-extrabold text-slate-800">{{ $booking->trainer->user->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">{{ $booking->trainer->specialization }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-800">
                            {{ $dayName }}, {{ $bookingDate->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($booking->status == \App\Models\Booking::CONFIRMED)
                                <span class="bg-green-50 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full uppercase">
                                    Đã xác nhận
                                </span>
                            @elseif($booking->status == \App\Models\Booking::PENDING)
                                <span class="bg-orange-50 text-orange-700 text-xs font-bold px-2.5 py-1 rounded-full uppercase animate-pulse">
                                    Chờ duyệt
                                </span>
                            @else
                                <span class="bg-slate-50 text-slate-400 text-xs font-bold px-2.5 py-1 rounded-full uppercase">
                                    Đã hủy
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($isUpcoming && ($booking->status == \App\Models\Booking::PENDING || $booking->status == \App\Models\Booking::CONFIRMED))
                                <form action="{{ route('member.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn PT này?');" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold hover:underline transition">
                                        Hủy lịch
                                    </button>
                                </form>
                            @else
                                <span class="text-slate-300 font-medium">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">
                            <div class="text-slate-300 mb-3">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12 mx-auto">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                            <h4>Chưa có lịch hẹn tập luyện nào</h4>
                            <p class="text-xs text-slate-400 mt-1 max-w-[250px] mx-auto leading-relaxed">Bạn có thể chọn và đăng ký lịch tập với Huấn luyện viên cá nhân.</p>
                            <a href="{{ route('member.bookings.create') }}" class="mt-4 inline-flex bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs px-4 py-2 rounded-xl transition shadow-md shadow-blue-500/10">
                                Đặt lịch ngay
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
