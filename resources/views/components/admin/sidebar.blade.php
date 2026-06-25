<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="absolute left-0 top-0 z-30 flex h-screen w-72 flex-col overflow-y-hidden sidebar-gradient duration-300 ease-linear lg:static lg:translate-x-0">
    <div class="relative flex h-full flex-col px-5 py-6 overflow-y-auto admin-scrollbar">
        <!-- Header / Logo -->
        <div class="mb-8 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="logo-ring flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-lg font-bold text-white shadow-lg shadow-indigo-500/20">
                    G
                </div>
                <div>
                    <p class="text-[0.65rem] uppercase tracking-[0.2em] text-slate-500 font-medium">Gym Management</p>
                    <h1 class="text-base font-semibold text-white">Admin Panel</h1>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white/5 text-slate-400 hover:bg-white/10 hover:text-white transition">
                <span class="sr-only">Đóng menu</span>
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Divider -->
        <div class="mb-4 h-px bg-gradient-to-r from-transparent via-slate-700 to-transparent"></div>

        <!-- Navigation Label -->
        <p class="mb-3 px-4 text-[0.65rem] uppercase tracking-[0.18em] text-slate-500 font-semibold">Menu chính</p>

        <nav class="space-y-1">
            @php
            $links = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
            ['label' => 'Hội viên', 'route' => 'admin.members.index', 'icon' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>'],
            ['label' => 'Nhân viên', 'route' => 'admin.staff.index', 'icon' => '<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
            ['label' => 'Huấn luyện viên', 'route' => 'admin.trainers.index', 'icon' => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>'],
            ['label' => 'Gói tập', 'route' => 'admin.packages.index', 'icon' => '<rect x="1" y="3" width="15" height="13" rx="2" ry="2"/><path d="M16 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2"/><line x1="6" y1="7" x2="12" y2="7"/><line x1="6" y1="11" x2="10" y2="11"/>'],
            ['label' => 'Giao dịch', 'route' => 'admin.payments.index', 'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>'],
            ['label' => 'Đặt lịch', 'route' => 'admin.bookings.index', 'icon' => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
            ['label' => 'Báo cáo', 'route' => 'admin.reports.index', 'icon' => '<path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>'],
            ];
            @endphp

            @foreach ($links as $item)
            @php
            $current = \Illuminate\Support\Facades\Route::currentRouteName() ?? '';
            $active = \Illuminate\Support\Str::startsWith($current, $item['route']);
            $url = \Illuminate\Support\Facades\Route::has($item['route']) ? route($item['route']) : '#';
            @endphp

            <a href="{{ $url }}" @click="if(window.innerWidth < 1024) sidebarOpen = false"
                class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl {{ $active ? 'active text-white' : 'text-slate-400 hover:text-white' }}">
                <svg class="h-[18px] w-[18px] flex-shrink-0 {{ $active ? 'text-indigo-400' : 'text-slate-500' }}" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    {!! $item['icon'] !!}
                </svg>
                <span>{{ $item['label'] }}</span>
                @if($active)
                <div class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse-dot"></div>
                @endif
            </a>
            @endforeach
        </nav>

        <!-- Spacer -->
        <div class="flex-1"></div>

        <!-- Sidebar Footer -->
        <div class="mt-6 pt-4 border-t border-slate-800/60">
            <div class="flex items-center gap-3 px-4 py-2">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500/20 to-violet-500/20 border border-indigo-500/20">
                    <svg class="w-4 h-4 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Phiên bản</p>
                    <p class="text-xs font-medium text-slate-400">v2.0 — Premium</p>
                </div>
            </div>
        </div>
    </div>
</aside>