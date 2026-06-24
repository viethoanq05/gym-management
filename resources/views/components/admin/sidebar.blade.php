<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="absolute left-0 top-0 z-30 flex h-screen w-72 flex-col overflow-y-hidden bg-slate-900 duration-300 ease-linear lg:static lg:translate-x-0">
    <div class="relative flex h-full flex-col px-5 py-6 overflow-y-auto">
        <div class="mb-8 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-600 text-xl font-bold text-white">G</div>
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Gym Management</p>
                    <h1 class="text-xl font-semibold text-white">Admin Panel</h1>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-md bg-slate-800 text-slate-200 hover:bg-slate-700">
                <span class="sr-only">Đóng menu</span>
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav @click="sidebarOpen = false" class="space-y-1 lg:space-y-2">
            @php
            $links = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M3 12h18M3 6h18M3 18h18'],
            ['label' => 'Hội viên', 'route' => 'admin.members.index', 'icon' => 'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'],
            ['label' => 'Nhân viên', 'route' => 'admin.staff.index', 'icon' => 'M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zM6 20v-2c0-2.21 1.79-4 4-4h4c2.21 0 4 1.79 4 4v2'],
            ['label' => 'Huấn luyện viên', 'route' => 'admin.trainers.index', 'icon' => 'M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8z'],
            ['label' => 'Gói tập', 'route' => 'admin.packages.index', 'icon' => 'M4 6h16M4 12h16M4 18h16'],
            ['label' => 'Giao dịch', 'route' => 'admin.payments.index', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Đặt lịch', 'route' => 'admin.bookings.index', 'icon' => 'M8 7V3m8 4V3M5 11h14M5 19h14'],
            ['label' => 'Báo cáo', 'route' => 'admin.reports.index', 'icon' => 'M4 7h16M4 12h10M4 17h7'],
            ];
            @endphp

            @foreach ($links as $item)
            @php
            $current = \Illuminate\Support\Facades\Route::currentRouteName() ?? '';
            $active = \Illuminate\Support\Str::startsWith($current, $item['route']);
            $url = \Illuminate\Support\Facades\Route::has($item['route']) ? route($item['route']) : '#';
            @endphp

            <a href="{{ $url }}" @click="if(window.innerWidth < 1024) sidebarOpen = false"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition rounded-xl {{ $active ? 'bg-blue-50 text-slate-900 border-l-4 border-blue-600' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-5 w-5 {{ $active ? 'text-blue-600' : 'text-slate-300' }}" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="{{ $item['icon'] }}" />
                </svg>
                {{ $item['label'] }}
            </a>
            @endforeach
        </nav>
    </div>
</aside>