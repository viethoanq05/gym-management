<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hội viên') - IRON CORE</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand: #1662ff;
            --brand-strong: #0f4ed1;
            --accent: #ff7a1a;
            --text: #101828;
            --muted: #667085;
            --surface: #ffffff;
            --soft: #f4f7fb;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background: #f8fafc;
        }
    </style>
</head>

<body class="min-h-screen flex overflow-x-hidden">
    <!-- Left Sidebar -->
    <aside class="hidden lg:flex flex-col w-52 xl:w-60 bg-white border-r border-slate-200 h-screen sticky top-0 p-4 xl:p-5 shrink-0 overflow-y-auto">
        <!-- Logo -->
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-blue-600 text-white p-2 rounded-xl">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="m6.5 6.5 11 11" />
                    <path d="m21 21-1-1" />
                    <path d="m3 3 1 1" />
                    <path d="m18 22 4-4" />
                    <path d="m2 6 4-4" />
                    <path d="m3 10h7v4H3z" transform="rotate(45 6.5 12)" />
                    <path d="m14 10h7v4h-7z" transform="rotate(45 17.5 12)" />
                </svg>
            </div>
            <div>
                <div class="font-extrabold text-base xl:text-lg text-slate-800 leading-none">Iron Core</div>
                <div class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase leading-none mt-1">Premium Management</div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 space-y-1">
            <a href="{{ route('member.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition {{ request()->routeIs('member.dashboard') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <rect x="3" y="3" width="7" height="9" rx="1" />
                    <rect x="14" y="3" width="7" height="5" rx="1" />
                    <rect x="14" y="12" width="7" height="9" rx="1" />
                    <rect x="3" y="16" width="7" height="5" rx="1" />
                </svg>
                <span>Tổng quan</span>
            </a>

            <a href="{{ route('member.packages') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition {{ request()->routeIs('member.packages') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg>
                <span>Gói tập</span>
            </a>

            <a href="{{ route('member.bookings.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition {{ request()->routeIs('member.bookings.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                <span>Đặt lịch PT</span>
            </a>

            <a href="{{ route('member.memberships.history') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition {{ request()->routeIs('member.memberships.history') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10 9 9 9 8 9" />
                </svg>
                <span>Lịch sử gói</span>
            </a>
        </nav>

        <!-- Upgrade and Bottom Options -->
        <div class="mt-auto pt-6 border-t border-slate-100">
            <a href="{{ route('member.packages') }}" class="block w-full bg-blue-600 text-white font-bold text-center text-xs py-3 px-4 rounded-xl transition shadow-lg shadow-blue-500/25 hover:bg-blue-700 hover:-translate-y-0.5 mb-6">
                Nâng cấp Pro
            </a>

            <div class="space-y-1">
                <a href="#" onclick="event.preventDefault(); openProfileModal();" class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                    <span>Cài đặt</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 hover:text-red-600 transition">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span>Đăng xuất</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Mobile Navigation Menu -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-50 flex justify-around py-2 shadow-lg">
        <a href="{{ route('member.dashboard') }}" class="flex flex-col items-center text-xs font-semibold {{ request()->routeIs('member.dashboard') ? 'text-blue-600' : 'text-slate-500' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mb-0.5">
                <rect x="3" y="3" width="7" height="9" rx="1" />
                <rect x="14" y="3" width="7" height="5" rx="1" />
                <rect x="14" y="12" width="7" height="9" rx="1" />
                <rect x="3" y="16" width="7" height="5" rx="1" />
            </svg>
            <span>Tổng quan</span>
        </a>
        <a href="{{ route('member.packages') }}" class="flex flex-col items-center text-xs font-semibold {{ request()->routeIs('member.packages') ? 'text-blue-600' : 'text-slate-500' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mb-0.5">
                <rect x="2" y="5" width="20" height="14" rx="2" />
                <line x1="2" y1="10" x2="22" y2="10" />
            </svg>
            <span>Gói tập</span>
        </a>
        <a href="{{ route('member.bookings.index') }}" class="flex flex-col items-center text-xs font-semibold {{ request()->routeIs('member.bookings.*') ? 'text-blue-600' : 'text-slate-500' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mb-0.5">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            <span>Đặt lịch</span>
        </a>
        <a href="{{ route('member.memberships.history') }}" class="flex flex-col items-center text-xs font-semibold {{ request()->routeIs('member.memberships.history') ? 'text-blue-600' : 'text-slate-500' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mb-0.5">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
            </svg>
            <span>Lịch sử</span>
        </a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex flex-col items-center text-xs font-semibold text-red-500">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mb-0.5">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
            </svg>
            <span>Đăng xuất</span>
        </a>
    </div>

    <!-- Main View Content Area -->
    <div class="flex-1 flex flex-col min-w-0 pb-16 lg:pb-0">
        <!-- Top Header Bar -->
        <header class="bg-white border-b border-slate-200 px-4 lg:px-6 py-3 flex items-center justify-between z-10 shrink-0">
            <h2 class="text-base lg:text-lg font-extrabold text-slate-800">@yield('header_title', 'Bảng điều khiển')</h2>
            
            <div class="flex items-center gap-2 lg:gap-3">
                {{-- Notification Bell --}}
                <div class="relative" id="notif-wrapper">
                    <button onclick="toggleNotif()" class="text-slate-400 hover:text-slate-600 transition p-2.5 rounded-xl hover:bg-slate-50 relative">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-[22px] h-[22px]">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                            <line x1="10" y1="14" x2="14" y2="14" />
                            <line x1="12" y1="12" x2="12" y2="16" />
                        </svg>
                        @if(isset($upcomingNotifications) && $upcomingNotifications->count() > 0)
                            <span class="absolute -top-0.5 -right-0.5 min-w-[20px] h-[20px] flex items-center justify-center bg-red-500 text-white text-[11px] font-bold rounded-full px-1 ring-2 ring-white">{{ $upcomingNotifications->count() }}</span>
                        @endif
                    </button>

                    {{-- Notification Dropdown (YouTube-style) --}}
                    <div id="notif-dropdown" class="hidden fixed w-[480px] bg-white rounded-2xl border border-slate-200 shadow-2xl z-[200] overflow-hidden" style="animation: fadeInDown .2s ease">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                            <h4 class="text-lg font-extrabold text-slate-800">Thông báo</h4>
                            @if(isset($upcomingNotifications) && $upcomingNotifications->count() > 0)
                                <span class="text-xs font-bold bg-blue-100 text-blue-600 px-3 py-1.5 rounded-full">{{ $upcomingNotifications->count() }} buổi sắp tới</span>
                            @endif
                        </div>
                        <div class="min-h-[280px] max-h-[480px] overflow-y-auto">
                            @forelse($upcomingNotifications ?? [] as $notif)
                                @php
                                    $bDate = \Carbon\Carbon::parse($notif->booking_date);
                                    $dayNames = [0=>'CN',1=>'T2',2=>'T3',3=>'T4',4=>'T5',5=>'T6',6=>'T7'];
                                    $isToday = $bDate->isToday();
                                    $isTomorrow = $bDate->isTomorrow();
                                @endphp
                                <div class="px-6 py-4 hover:bg-slate-50 transition border-b border-slate-100 last:border-0 flex items-center gap-4">
                                    <div class="shrink-0 w-14 h-14 rounded-2xl flex flex-col items-center justify-center {{ $isToday ? 'bg-orange-100 text-orange-600' : ($isTomorrow ? 'bg-blue-100 text-blue-600' : 'bg-slate-100 text-slate-500') }}">
                                        <span class="text-base font-extrabold leading-none">{{ $bDate->format('d') }}</span>
                                        <span class="text-[10px] font-bold mt-0.5 uppercase">{{ $dayNames[$bDate->dayOfWeek] }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[15px] font-bold text-slate-800">
                                            @if($isToday) Hôm nay @elseif($isTomorrow) Ngày mai @else Ngày {{ $bDate->format('d/m') }} @endif
                                        </div>
                                        <div class="text-sm text-slate-500 font-medium mt-1">
                                            {{ \Carbon\Carbon::parse($notif->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($notif->end_time)->format('H:i') }}
                                            <span class="text-slate-300 mx-1">|</span>
                                            HLV {{ $notif->trainer->user->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <span class="shrink-0 text-xs font-bold px-3 py-1.5 rounded-full {{ $notif->status == 1 ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                        {{ $notif->status == 1 ? 'Đã xác nhận' : 'Chờ duyệt' }}
                                    </span>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center min-h-[280px] text-center px-6">
                                    <div class="text-slate-300 mb-4">
                                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-14 h-14 mx-auto"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    </div>
                                    <p class="text-base font-bold text-slate-500">Không có lịch tập sắp tới</p>
                                    <p class="text-sm text-slate-400 mt-1.5">Đặt lịch PT để bắt đầu tập luyện nhé!</p>
                                    <a href="{{ route('member.bookings.create') }}" class="mt-4 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition shadow-lg shadow-blue-500/20">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-4 h-4"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Đặt lịch PT ngay
                                    </a>
                                </div>
                            @endforelse
                        </div>
                        <a href="{{ route('member.bookings.index') }}" class="block text-center text-sm font-bold text-blue-600 hover:bg-blue-50 py-4 border-t border-slate-100 transition">Xem tất cả lịch hẹn →</a>
                    </div>
                </div>

                <div class="w-px h-6 bg-slate-200"></div>

                {{-- Avatar Popup --}}
                <div class="relative" id="avatar-wrapper">
                    <button onclick="toggleAvatar()" class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=1662ff&color=fff&bold=true' }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border-2 border-blue-500">
                        <div class="hidden sm:block text-left">
                            <div class="text-sm font-extrabold text-slate-800 leading-none">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase mt-1 leading-none">Hội viên</div>
                        </div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-3.5 h-3.5 text-slate-400 hidden sm:block"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>

                    {{-- Avatar Dropdown (YouTube-style) --}}
                    <div id="avatar-dropdown" class="hidden fixed w-[300px] bg-white rounded-2xl border border-slate-200 shadow-2xl z-[200] overflow-hidden" style="animation: fadeInDown .2s ease">
                        {{-- Profile header --}}
                        <div class="px-5 py-5 border-b border-slate-100 flex items-center gap-4">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=1662ff&color=fff&bold=true&size=80' }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover border-2 border-blue-500 shrink-0">
                            <div class="min-w-0">
                                <div class="text-base font-extrabold text-slate-800 truncate">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-slate-400 font-medium truncate mt-0.5">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        {{-- Menu items --}}
                        <div class="py-2">
                            <button onclick="openProfileModal()" class="w-full flex items-center gap-4 px-5 py-3.5 text-[15px] font-semibold text-slate-700 hover:bg-slate-50 transition text-left">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-[22px] h-[22px] text-slate-500 shrink-0"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Sửa thông tin
                            </button>
                            <div class="border-t border-slate-100 mx-4 my-1"></div>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-4 px-5 py-3.5 text-[15px] font-semibold text-red-500 hover:bg-red-50 transition">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-[22px] h-[22px] shrink-0"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Đăng xuất
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 lg:p-5">
            <!-- Alert Messages -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold rounded-xl flex items-center gap-3">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-green-600 shrink-0">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-sm font-semibold rounded-xl flex items-center gap-3">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-red-600 shrink-0">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <div>{{ session('error') }}</div>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Edit Profile Modal --}}
    <div id="profile-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-md" onclick="closeProfileModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" style="animation: modalIn .25s ease">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-extrabold text-slate-800">Chỉnh sửa thông tin</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ Auth::user()->email }}</p>
                </div>
                <button onclick="closeProfileModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-5 h-5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <form id="profile-form" class="p-5 space-y-3">
                <div id="profile-success" class="hidden p-3 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold rounded-xl"></div>
                <div id="profile-error" class="hidden p-3 bg-red-50 border border-red-200 text-red-700 text-sm font-semibold rounded-xl"></div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Họ tên</label>
                        <input type="text" name="name" id="pf-name" value="{{ Auth::user()->name }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Số điện thoại</label>
                        <input type="text" name="phone" id="pf-phone" value="{{ Auth::user()->phone }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Giới tính</label>
                        <select name="gender" id="pf-gender" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                            <option value="male" {{ Auth::user()->member?->gender === 'male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ Auth::user()->member?->gender === 'female' ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Ngày sinh</label>
                        <input type="date" name="dob" id="pf-dob" value="{{ Auth::user()->member?->dob?->format('Y-m-d') }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Chiều cao (cm)</label>
                        <input type="number" name="height" id="pf-height" step="0.01" value="{{ Auth::user()->member?->height }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Cân nặng (kg)</label>
                        <input type="number" name="weight" id="pf-weight" step="0.01" value="{{ Auth::user()->member?->weight }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" id="pf-submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-2.5 rounded-xl transition shadow-lg shadow-blue-500/20">
                        Lưu thay đổi
                    </button>
                    <button type="button" onclick="closeProfileModal()" class="px-5 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold text-sm rounded-xl transition">
                        Hủy
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes modalIn { from { opacity: 0; transform: scale(.95); } to { opacity: 1; transform: scale(1); } }
    </style>

    <script>
        function positionDropdown(triggerEl, dropdownEl) {
            const rect = triggerEl.getBoundingClientRect();
            // Temporarily show offscreen to measure real width
            dropdownEl.style.visibility = 'hidden';
            dropdownEl.style.display = 'block';
            const ddWidth = dropdownEl.offsetWidth;
            const ddHeight = dropdownEl.offsetHeight;
            dropdownEl.style.display = '';
            dropdownEl.style.visibility = '';

            // Align right edge of dropdown with right edge of trigger
            let left = rect.right - ddWidth;
            const top = rect.bottom + 10;

            // Prevent going off left edge
            if (left < 8) left = 8;
            // Prevent going off right edge
            if (left + ddWidth > window.innerWidth - 8) {
                left = window.innerWidth - ddWidth - 8;
            }

            dropdownEl.style.top = top + 'px';
            dropdownEl.style.left = left + 'px';
        }

        function toggleNotif() {
            const dd = document.getElementById('notif-dropdown');
            const avatarDd = document.getElementById('avatar-dropdown');
            const btn = document.querySelector('#notif-wrapper button');
            avatarDd.classList.add('hidden');
            if (dd.classList.contains('hidden')) {
                dd.classList.remove('hidden');
                positionDropdown(btn, dd);
            } else {
                dd.classList.add('hidden');
            }
        }
        function toggleAvatar() {
            const dd = document.getElementById('avatar-dropdown');
            const notifDd = document.getElementById('notif-dropdown');
            const btn = document.querySelector('#avatar-wrapper button');
            notifDd.classList.add('hidden');
            if (dd.classList.contains('hidden')) {
                dd.classList.remove('hidden');
                positionDropdown(btn, dd);
            } else {
                dd.classList.add('hidden');
            }
        }
        function openProfileModal() {
            document.getElementById('avatar-dropdown').classList.add('hidden');
            document.getElementById('profile-modal').classList.remove('hidden');
            document.getElementById('profile-success').classList.add('hidden');
            document.getElementById('profile-error').classList.add('hidden');
        }
        function closeProfileModal() {
            document.getElementById('profile-modal').classList.add('hidden');
        }

        // Close dropdowns on outside click
        document.addEventListener('click', function(e) {
            if (!document.getElementById('notif-wrapper').contains(e.target)) {
                document.getElementById('notif-dropdown').classList.add('hidden');
            }
            if (!document.getElementById('avatar-wrapper').contains(e.target)) {
                document.getElementById('avatar-dropdown').classList.add('hidden');
            }
        });

        // Profile form AJAX submit
        document.getElementById('profile-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('pf-submit');
            const successEl = document.getElementById('profile-success');
            const errorEl = document.getElementById('profile-error');
            successEl.classList.add('hidden');
            errorEl.classList.add('hidden');
            btn.disabled = true;
            btn.textContent = 'Đang lưu...';

            const formData = {
                name: document.getElementById('pf-name').value,
                phone: document.getElementById('pf-phone').value,
                gender: document.getElementById('pf-gender').value,
                dob: document.getElementById('pf-dob').value,
                height: document.getElementById('pf-height').value,
                weight: document.getElementById('pf-weight').value,
            };

            try {
                const res = await fetch("{{ route('member.profile.update') }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(formData),
                });
                const data = await res.json();
                if (res.ok) {
                    successEl.textContent = data.message;
                    successEl.classList.remove('hidden');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    let msg = data.message || 'Có lỗi xảy ra.';
                    if (data.errors) {
                        msg = Object.values(data.errors).flat().join(' ');
                    }
                    errorEl.textContent = msg;
                    errorEl.classList.remove('hidden');
                }
            } catch (err) {
                errorEl.textContent = 'Lỗi kết nối, vui lòng thử lại.';
                errorEl.classList.remove('hidden');
            }
            btn.disabled = false;
            btn.textContent = 'Lưu thay đổi';
        });
    </script>
</body>

</html>
