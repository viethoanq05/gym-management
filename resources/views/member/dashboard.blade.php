@extends('member.layout')

@section('title', 'Tổng quan')
@section('header_title', 'Trang chủ')

@section('content')
@php
    $hour = now()->hour;
    $greeting = 'Chào buổi sáng';
    if ($hour >= 12 && $hour < 18) {
        $greeting = 'Chào buổi chiều';
    } elseif ($hour >= 18) {
        $greeting = 'Chào buổi tối';
    }
@endphp

<!-- Greeting Banner -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
    <div>
        <h1 class="text-2xl xl:text-3xl font-extrabold text-slate-800 tracking-tight">
            {{ $greeting }}, {{ Auth::user()->name }}!
        </h1>
    </div>
    
    <div>
        <a href="{{ route('member.bookings.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-lg shadow-blue-500/20 whitespace-nowrap">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>Đặt lịch PT mới</span>
        </a>
    </div>
</div>

<!-- Dashboard Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 xl:gap-5 max-w-full">
    
    <!-- Left column: Current package & Target weight / Recent activity -->
    <div class="lg:col-span-2 space-y-4 xl:space-y-6">
        
        <!-- Active Package Card -->
        <div class="bg-white rounded-2xl border border-slate-100 p-4 xl:p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Gói tập hiện tại</span>
                    
                    @if($activeMembership)
                        <h2 class="text-2xl xl:text-3xl font-extrabold text-slate-800 mt-2 leading-none">
                            {{ $activeMembership->package->name }}
                        </h2>
                        
                        <div class="flex items-center gap-2 mt-4 text-blue-600 text-sm font-bold bg-blue-50 px-3 py-1 rounded-full w-fit">
                            <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                            <span>Đang hoạt động</span>
                        </div>
                    @else
                        <h2 class="text-2xl font-extrabold text-slate-400 mt-2">
                            Chưa đăng ký gói tập
                        </h2>
                        <a href="{{ route('member.packages') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800 text-sm font-bold">
                            Đăng ký gói ngay →
                        </a>
                    @endif
                </div>

                @if($activeMembership)
                    @php
                        $startDate = \Carbon\Carbon::parse($activeMembership->start_date);
                        $endDate = \Carbon\Carbon::parse($activeMembership->end_date);
                        $totalDays = (int) $startDate->diffInDays($endDate);
                        $daysPassed = (int) $startDate->diffInDays(now());
                        $daysLeft = (int) now()->diffInDays($endDate, false);
                        $daysLeft = $daysLeft < 0 ? 0 : $daysLeft;
                        $progressPct = $totalDays > 0 ? min(100, max(0, round(($daysPassed / $totalDays) * 100))) : 0;
                    @endphp
                    
                    <div class="text-right shrink-0">
                        <div class="text-xs font-bold text-slate-500">
                            Đã dùng {{ $daysPassed }} ngày <span class="text-slate-300 font-normal">/</span> {{ $totalDays }} ngày
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="w-36 xl:w-48 h-2 bg-slate-100 rounded-full overflow-hidden mt-2">
                            <div class="h-full bg-blue-600 rounded-full" style="width: {{ $progressPct }}%"></div>
                        </div>
                    </div>
                @endif
            </div>

            @if($activeMembership)
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 mt-5 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-2 text-slate-500 font-semibold text-sm">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-orange-500">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>Còn lại <strong class="text-slate-800 font-extrabold">{{ $daysLeft }} ngày</strong></span>
                    </div>

                    <a href="{{ route('member.packages') }}" class="border border-slate-200 hover:border-slate-300 text-slate-700 font-extrabold text-xs px-4 py-2 rounded-xl transition text-center hover:bg-slate-50">
                        Gia hạn gói
                    </a>
                </div>
            @endif
        </div>

        <!-- Inner Grid: Weight target & Recent activity -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            
            <!-- Monthly Training Stats Card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-4 xl:p-5 md:col-span-2 shadow-sm flex flex-col justify-between">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-orange-50 text-orange-500 p-2 rounded-xl">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                        </svg>
                    </span>
                    <h3 class="text-sm font-bold text-slate-700">Thống kê tháng {{ now()->month }}</h3>
                </div>

                @php
                    $daysInMonth = now()->daysInMonth;
                    $checkinPct = $daysInMonth > 0 ? min(100, round(($monthlyCheckinCount / $daysInMonth) * 100)) : 0;
                @endphp

                <!-- Circle Progress Gauge -->
                <div class="relative flex items-center justify-center my-2 xl:my-3">
                    <svg class="w-24 h-24 xl:w-28 xl:h-28 transform -rotate-90" viewBox="0 0 128 128">
                        <!-- Background Circle -->
                        <circle cx="64" cy="64" r="50" stroke="#f1f5f9" stroke-width="10" fill="transparent" />
                        <!-- Active Circle -->
                        <circle cx="64" cy="64" r="50" stroke="#ff7a1a" stroke-width="10" fill="transparent"
                                stroke-dasharray="314.16"
                                stroke-dashoffset="{{ 314.16 - (314.16 * $checkinPct / 100) }}"
                                stroke-linecap="round" />
                    </svg>
                    <div class="absolute text-center">
                        <span class="text-2xl xl:text-3xl font-extrabold text-slate-800">{{ $monthlyCheckinCount }}</span>
                        <div class="text-[10px] font-bold text-slate-400 -mt-0.5">buổi tập</div>
                    </div>
                </div>

                <div class="flex justify-center items-center text-xs font-semibold text-slate-400 mt-1.5 border-t border-slate-50 pt-3">
                    <div class="text-center">
                        <div>Đã check-in</div>
                        <div class="text-sm font-extrabold text-slate-700 mt-0.5">{{ $monthlyCheckinCount }} / {{ $daysInMonth }} ngày</div>
                    </div>
                </div>
            </div>

            <!-- Check-in History Card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-4 xl:p-5 md:col-span-3 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-slate-700">Hoạt động gần đây</h3>
                        <span class="text-xs font-bold text-blue-600 hover:underline cursor-pointer">Xem tất cả</span>
                    </div>

                    <div class="space-y-3">
                        @forelse($recentCheckins as $checkin)
                            @php
                                $checkinTime = \Carbon\Carbon::parse($checkin->checkin_time);
                                $checkoutTime = $checkin->checkout_time ? \Carbon\Carbon::parse($checkin->checkout_time) : null;
                                $duration = $checkoutTime ? $checkinTime->diffInMinutes($checkoutTime) . ' phút' : 'Đang tập';
                                $isActive = !$checkoutTime;
                            @endphp
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <div class="flex items-center gap-3">
                                    <span class="{{ $isActive ? 'bg-green-50 text-green-600' : 'bg-blue-50 text-blue-600' }} p-2.5 rounded-full">
                                        @if($isActive)
                                            {{-- Active check-in icon --}}
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                                <polyline points="10 17 15 12 10 7"/>
                                                <line x1="15" y1="12" x2="3" y2="12"/>
                                            </svg>
                                        @else
                                            {{-- Completed check-in icon --}}
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                                <polyline points="22 4 12 14.01 9 11.01"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <div>
                                        <div class="font-extrabold text-slate-800">
                                            Check-in tại phòng gym
                                        </div>
                                        <div class="text-xs text-slate-400 font-medium mt-0.5">
                                            {{ $checkinTime->diffForHumans() }}, {{ $checkinTime->format('H:i') }}
                                            @if($checkoutTime)
                                                → {{ $checkoutTime->format('H:i') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <span class="{{ $isActive ? 'bg-green-50 text-green-600 animate-pulse' : 'bg-orange-50 text-orange-600' }} text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase shrink-0">
                                    {{ $duration }}
                                </span>
                            </div>
                        @empty
                            {{-- Empty state --}}
                            <div class="flex flex-col items-center justify-center py-6 text-center">
                                <div class="text-slate-300 mb-3">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-9 h-9 mx-auto">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                        <polyline points="10 17 15 12 10 7"/>
                                        <line x1="15" y1="12" x2="3" y2="12"/>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-bold text-slate-700">Chưa có lượt check-in nào</h4>
                                <p class="text-xs text-slate-400 max-w-[220px] mt-1 mx-auto leading-relaxed">
                                    Hãy đến phòng gym và check-in để bắt đầu hành trình tập luyện!
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Right column: Upcoming PT bookings -->
    <div class="bg-white rounded-2xl border border-slate-100 p-4 xl:p-5 shadow-sm flex flex-col justify-between min-h-[320px]">
        <div>
            <!-- Header -->
            <div class="flex items-center gap-3 mb-6">
                <span class="bg-blue-50 text-blue-600 p-2.5 rounded-xl">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                <h3 class="text-sm font-bold text-slate-700">Lịch hẹn PT sắp tới</h3>
            </div>

            <!-- List of upcoming bookings -->
            <div class="space-y-4">
                @forelse($upcomingBookings as $booking)
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
                        $timeFormatted = \Carbon\Carbon::parse($booking->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($booking->end_time)->format('H:i');
                    @endphp
                    
                    <div class="rounded-xl border border-slate-100 p-4 relative bg-slate-50/50 hover:bg-slate-50 transition">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wide">
                            {{ $dayName }}, {{ $timeFormatted }}
                        </div>
                        <div class="text-sm font-extrabold text-slate-700 mt-1">
                            Ngày {{ $bookingDate->day }} tháng {{ $bookingDate->month }}
                        </div>
                        
                        <!-- Trainer Card Info -->
                        <div class="flex items-center gap-3 mt-4 bg-white p-3 rounded-lg border border-slate-100 shadow-sm">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->trainer->user->name) }}&background=e2e8f0&color=475569&bold=true" class="w-9 h-9 rounded-full object-cover shrink-0">
                            <div class="min-w-0 flex-1">
                                <div class="text-xs text-slate-400 font-bold uppercase tracking-wide">Huấn luyện viên</div>
                                <div class="text-sm font-extrabold text-slate-700 mt-0.5 truncate">{{ $booking->trainer->user->name }}</div>
                            </div>
                            
                            <!-- Action Cancel Dropdown / Button -->
                            <form action="{{ route('member.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn PT này?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-slate-400 hover:text-red-500 transition p-1 hover:bg-red-50 rounded" title="Hủy lịch hẹn">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="text-slate-300 mb-3">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 mx-auto">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-700">Chưa có lịch PT nào</h4>
                        <p class="text-xs text-slate-400 max-w-[200px] mt-1 mx-auto leading-relaxed">Hãy đặt lịch với huấn luyện viên cá nhân để đạt hiệu quả tối đa.</p>
                        
                        <a href="{{ route('member.bookings.create') }}" class="mt-3 inline-flex items-center gap-2 bg-blue-50 text-blue-600 hover:bg-blue-100 font-extrabold text-xs px-4 py-2 rounded-xl transition">
                            <span>Đặt lịch PT ngay</span>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Helpful tip widget -->
        @if(!$upcomingBookings->isEmpty())
            <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-50 mt-6 text-xs text-blue-700 leading-relaxed font-semibold">
                💡 Bạn vui lòng đến đúng giờ để buổi tập luyện đạt kết quả tốt nhất. Hủy lịch hẹn trước ít nhất 2 tiếng nếu có thay đổi.
            </div>
        @endif
    </div>

</div>

@endsection
