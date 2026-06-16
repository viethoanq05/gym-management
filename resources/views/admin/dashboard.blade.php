<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Gym Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f3f6fb;
        }
    </style>
</head>

<body class="min-h-screen bg-[#f3f6fb] text-slate-900">
    <div class="min-h-screen bg-[#f3f6fb] px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto grid max-w-[1500px] gap-6 xl:grid-cols-[280px_1fr]">

            <aside class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                <div class="mb-10 flex items-center gap-3 rounded-3xl bg-slate-900 px-4 py-4 text-white shadow-[0_20px_60px_rgba(15,23,42,0.1)]">
                    <div class="grid h-11 w-11 place-items-center rounded-2xl bg-blue-500 text-xl font-bold">Pro</div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-300">Gym Management</p>
                        <p class="text-sm font-semibold">Premium</p>
                    </div>
                </div>
                <nav class="space-y-2 text-sm font-medium text-slate-700">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-3xl bg-blue-50 px-4 py-3 text-slate-900 shadow-sm shadow-blue-200/40">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">🏠</span>
                        Tổng quan
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-3xl px-4 py-3 transition hover:bg-slate-100">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-600">👥</span>
                        Hội viên
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-3xl px-4 py-3 transition hover:bg-slate-100">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-600">🧑‍💼</span>
                        Nhân viên
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-3xl px-4 py-3 transition hover:bg-slate-100">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-600">📦</span>
                        Gói tập
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-3xl px-4 py-3 transition hover:bg-slate-100">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-600">📅</span>
                        Đặt lịch
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-3xl px-4 py-3 transition hover:bg-slate-100">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-600">📊</span>
                        Báo cáo
                    </a>
                </nav>
                <div class="mt-10 rounded-[24px] bg-slate-900 px-5 py-6 text-white">
                    <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Cài đặt</p>
                    <p class="mt-2 text-sm font-semibold">{{ Auth::user()->name ?? 'Quản trị viên' }}</p>

                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="text-sm text-red-400 hover:text-red-300">Đăng xuất ➜</button>
                    </form>
                </div>
            </aside>

            <main class="space-y-6">
                <header class="rounded-[28px] border border-slate-200 bg-white px-6 py-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Tổng quan hệ thống</p>
                            <h1 class="mt-3 text-3xl font-bold text-slate-900">Chào mừng trở lại, {{ Auth::user()->name ?? 'Admin' }}</h1>
                        </div>
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <label class="relative block w-full sm:w-auto">
                                <span class="sr-only">Tìm kiếm</span>
                                <input type="search" placeholder="Tìm kiếm hội viên..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100" />
                                <span class="pointer-events-none absolute inset-y-0 right-4 inline-flex items-center text-slate-400">🔍</span>
                            </label>
                            <button class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-700">Check In nhanh</button>
                        </div>
                    </div>
                </header>

                <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <p class="text-sm font-semibold text-slate-500">Tổng Hội viên</p>
                        <h2 class="mt-4 text-3xl font-bold text-slate-900">{{ $totalMembers ?? 0 }}</h2>
                    </article>
                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <p class="text-sm font-semibold text-slate-500">Hội viên mới (Tháng)</p>
                        <h2 class="mt-4 text-3xl font-bold text-slate-900">{{ $totalNewMembers ?? 0 }}</h2>
                    </article>
                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <p class="text-sm font-semibold text-slate-500">Doanh thu tháng (VND)</p>
                        <h2 class="mt-4 text-3xl font-bold text-slate-900">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h2>
                    </article>
                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-500">Lượt check-in</p>
                                <h2 class="mt-4 text-3xl font-bold text-slate-900">{{ $totalCheckIns ?? 0 }}</h2>
                            </div>
                            <span class="rounded-3xl bg-slate-100 px-3 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-slate-600">Hôm nay</span>
                        </div>
                    </article>
                </section>

                <section class="grid gap-6 xl:grid-cols-[1.4fr_0.8fr]">
                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Xu hướng doanh thu</p>
                                <h2 class="mt-3 text-2xl font-bold text-slate-900">7 ngày gần nhất</h2>
                            </div>
                            <div class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Tuần này</div>
                        </div>
                        <div class="overflow-hidden rounded-[24px] bg-slate-50 p-6">
                            <div class="mb-6 flex items-center justify-between text-sm text-slate-500">
                                <span>Doanh thu</span>
                                <span>VNĐ</span>
                            </div>
                            <div class="h-72 w-full">
                                <canvas id="revenueChart" class="w-full h-full"></canvas>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Lịch đặt mới</p>
                                <h2 class="mt-3 text-2xl font-bold text-slate-900">Xem tất cả</h2>
                            </div>
                            <button class="rounded-3xl bg-slate-100 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-slate-700">Xem tất cả</button>
                        </div>

                        <div class="space-y-4">
                            @if(isset($recentActivities) && $recentActivities->isNotEmpty())
                            @foreach($recentActivities as $activity)
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-900">{{ $activity->user_name }} đã đặt lịch tập</p>
                                <p class="mt-1 text-xs text-slate-500">Mã lịch: #{{ $activity->id }} • {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</p>
                            </div>
                            @endforeach
                            @else
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 text-center">
                                <p class="text-sm font-semibold text-slate-500">Chưa có hoạt động nào gần đây</p>
                            </div>
                            @endif
                        </div>
                    </article>
                </section>
            </main>
        </div>
    </div>

    <div id="dashboard-chart-data"
        data-labels='@json($chartLabels ?? [])'
        data-values='@json($chartData ?? [])'
        style="display: none;"></div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Bọc toàn bộ code vào window.onload để chắc chắn thẻ canvas đã hiển thị xong trên trình duyệt
        window.onload = function() {
            const canvasElement = document.getElementById('revenueChart');
            const chartDataElement = document.getElementById('dashboard-chart-data');

            // Kiểm tra bảo vệ nếu không tìm thấy thẻ canvas thì không chạy tiếp để tránh sập trang
            if (!canvasElement) {
                console.error("Không tìm thấy thẻ canvas với id 'revenueChart'!");
                return;
            }

            const ctx = canvasElement.getContext('2d');
            const labels = JSON.parse((chartDataElement && chartDataElement.dataset.labels) || '[]');
            const dataValues = JSON.parse((chartDataElement && chartDataElement.dataset.values) || '[]');

            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Doanh thu ngày',
                        data: dataValues,
                        borderColor: '#2563eb',
                        backgroundColor: gradient,
                        borderWidth: 4,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#2563eb',
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(226, 232, 240, 0.6)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('vi-VN') + ' đ';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        };
    </script>
</body>

</html>