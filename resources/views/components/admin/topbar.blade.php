<header class="flex items-center justify-between bg-white px-4 py-4 sm:px-6 border-b" x-data="{ adminOpen: false }">
    <button @click.stop="sidebarOpen = !sidebarOpen" class="block lg:hidden rounded-md p-2 text-slate-500 hover:bg-slate-100">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div class="flex-1"></div>

    <div class="relative inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-2 shadow-sm ml-auto">
        <!-- Nút chuông thông báo -->
        <button id="btn-request-notification" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-600 transition hover:bg-slate-200" title="Bật thông báo trình duyệt">
            <span class="sr-only">Thông báo</span>
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                <path d="M13.73 21a2 2 0 0 1-3.46 0" />
            </svg>
        </button>

        <!-- Dropdown Admin Profile -->
        <div class="relative inline-flex items-center gap-3">
            <button @click.stop="adminOpen = !adminOpen" class="inline-flex h-11 items-center gap-3 rounded-2xl bg-slate-50 px-4 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold text-white">A</span>
                <span>Admin</span>
                <svg class="h-4 w-4 text-slate-500 transition" :class="{ 'rotate-180': adminOpen }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9l6 6 6-6" />
                </svg>
            </button>

            <!-- Menu Dropdown -->
            <div x-show="adminOpen" @click.outside="adminOpen = false" class="absolute right-0 top-full mt-2 w-48 rounded-2xl bg-white shadow-lg border border-slate-200 z-50" style="display: none;">
                <button @click="document.getElementById('logoutForm').submit()" class="w-full text-left px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 hover:text-red-600 transition flex items-center gap-2 rounded-2xl">
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