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
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition">
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
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden pb-16 lg:pb-0">
        <!-- Top Header Bar -->
        <header class="bg-white border-b border-slate-200 px-4 lg:px-6 py-3 flex items-center justify-between z-10 shrink-0">
            <h2 class="text-base lg:text-lg font-extrabold text-slate-800">@yield('header_title', 'Bảng điều khiển')</h2>
            
            <div class="flex items-center gap-2 lg:gap-3">
                <!-- Notifications -->
                <button class="text-slate-400 hover:text-slate-600 transition p-2 rounded-lg hover:bg-slate-50 relative">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

        
                <div class="w-px h-6 bg-slate-200"></div>

                <!-- User Profile Info -->
                <div class="flex items-center gap-3">
                    <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=1662ff&color=fff&bold=true' }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border-2 border-blue-500">
                    <div class="hidden sm:block text-left">
                        <div class="text-sm font-extrabold text-slate-800 leading-none">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase mt-1 leading-none">Hội viên</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-5">
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
</body>

</html>
