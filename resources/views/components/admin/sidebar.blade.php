<nav class="space-y-1">
    @php
    $links = [
    ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M3 12h18M3 6h18M3 18h18'],
    ['label' => 'Hội viên', 'route' => 'admin.members.index', 'icon' => 'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'],
    ['label' => 'Nhân viên/PT', 'route' => 'admin.staff.index', 'icon' => 'M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zM6 20v-2c0-2.21 1.79-4 4-4h4c2.21 0 4 1.79 4 4v2'],
    ['label' => 'Gói tập', 'route' => 'admin.packages.index', 'icon' => 'M4 6h16M4 12h16M4 18h16'],
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

    <a href="{{ $url }}"
        class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition rounded-xl {{ $active ? 'bg-blue-50 text-slate-900 border-l-4 border-blue-600' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <svg class="h-5 w-5 {{ $active ? 'text-blue-600' : 'text-slate-300' }}" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="{{ $item['icon'] }}" />
        </svg>
        {{ $item['label'] }}
    </a>
    @endforeach
</nav>