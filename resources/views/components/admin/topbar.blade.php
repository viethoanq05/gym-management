<header class="topbar-glass flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8" x-data="{ adminOpen: false }">
    <!-- Left: Mobile menu + Breadcrumb -->
    <div class="flex items-center gap-4">
        <button @click.stop="sidebarOpen = !sidebarOpen" class="block lg:hidden rounded-lg p-2 text-slate-400 hover:bg-white/5 hover:text-white transition">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div class="hidden sm:block">
            <p class="text-sm font-medium text-slate-300">@yield('title', 'Dashboard')</p>
            <p class="text-xs text-slate-500 mt-0.5">{{ \Carbon\Carbon::now()->locale('vi')->translatedFormat('l, d/m/Y') }}</p>
        </div>
    </div>

    <!-- Right: Search + Notification + Profile -->
    <div class="flex items-center gap-2 sm:gap-3">
        <!-- Search (expandable) -->
        <div x-data="{ searchOpen: false }" class="relative hidden sm:block">
            <button @click="searchOpen = !searchOpen" x-show="!searchOpen"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/5 text-slate-400 transition hover:bg-white/10 hover:text-white">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </button>
            <div x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 w-0" x-transition:enter-end="opacity-100 w-64"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 w-64" x-transition:leave-end="opacity-0 w-0"
                class="flex items-center gap-2 rounded-xl bg-white/5 border border-white/10 px-3 overflow-hidden" @click.outside="searchOpen = false" style="display: none;">
                <svg class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" placeholder="Tìm kiếm..." class="w-full bg-transparent text-sm text-slate-200 placeholder-slate-500 py-2.5 outline-none border-none focus:ring-0" x-ref="searchInput" @keyup.escape="searchOpen = false">
                <button @click="searchOpen = false" class="text-slate-500 hover:text-slate-300 flex-shrink-0">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Notification Button -->
        <button id="btn-request-notification" class="relative inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/5 text-slate-400 transition hover:bg-white/10 hover:text-white" title="Bật thông báo trình duyệt">
            <span class="sr-only">Thông báo</span>
            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                <path d="M13.73 21a2 2 0 0 1-3.46 0" />
            </svg>
            <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-indigo-500"></span>
            </span>
        </button>

        <!-- Divider -->
        <div class="hidden sm:block h-8 w-px bg-white/10"></div>

        <!-- Admin Profile Dropdown -->
        <div class="relative inline-flex items-center">
            <button @click.stop="adminOpen = !adminOpen" class="inline-flex items-center gap-2.5 rounded-xl bg-white/5 border border-white/[0.06] px-3 py-2 text-sm transition hover:bg-white/10">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 text-xs font-bold text-white shadow-lg shadow-indigo-500/20">A</span>
                <div class="hidden sm:block text-left">
                    <span class="block text-sm font-medium text-slate-200">Admin</span>
                    <span class="block text-[0.65rem] text-slate-500">Quản trị viên</span>
                </div>
                <svg class="h-3.5 w-3.5 text-slate-500 transition" :class="{ 'rotate-180': adminOpen }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9l6 6 6-6" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="adminOpen" @click.outside="adminOpen = false"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 -translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                class="dropdown-menu absolute right-0 top-full mt-2 w-52 z-50 p-1" style="display: none;">
                <div class="px-3 py-2 border-b border-white/5 mb-1">
                    <p class="text-xs text-slate-500">Đã đăng nhập với vai trò</p>
                    <p class="text-sm font-medium text-slate-300">Quản trị viên</p>
                </div>
                <button @click="document.getElementById('logoutForm').submit()" class="dropdown-item w-full text-red-400 hover:text-red-300 rounded-lg">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span>Đăng xuất</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Form Logout ẩn -->
    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationBtn = document.getElementById('btn-request-notification');

        if (notificationBtn) {
            notificationBtn.addEventListener('click', function() {
                // Kiểm tra xem trình duyệt có hỗ trợ Notification API
                if (!('Notification' in window)) {
                    alert('Trình duyệt của bạn không hỗ trợ thông báo.');
                    return;
                }

                // Nếu đã cấp quyền
                if (Notification.permission === 'granted') {
                    new Notification('Thành công', {
                        body: 'Bạn đã bật thông báo!',
                        icon: '/img/icon-192x192.png'
                    });
                    return;
                }

                // Nếu chưa được hỏi hoặc từ chối
                if (Notification.permission !== 'denied') {
                    Notification.requestPermission().then(function(permission) {
                        if (permission === 'granted') {
                            new Notification('Thành công', {
                                body: 'Bạn đã bật thông báo!',
                                icon: '/img/icon-192x192.png'
                            });
                        } else if (permission === 'denied') {
                            alert('Bạn đã từ chối nhận thông báo.');
                        }
                    }).catch(function(error) {
                        console.error('Lỗi khi yêu cầu quyền thông báo:', error);
                        alert('Đã xảy ra lỗi khi yêu cầu quyền thông báo.');
                    });
                } else {
                    alert('Bạn đã từ chối nhận thông báo. Vui lòng bật lại trong cài đặt trình duyệt.');
                }
            });
        }
    });
</script>