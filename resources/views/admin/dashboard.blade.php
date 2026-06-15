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
                    <a href="#" class="flex items-center gap-3 rounded-3xl bg-blue-50 px-4 py-3 text-slate-900 shadow-sm shadow-blue-200/40">
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
                    <p class="mt-2 text-sm font-semibold">Quản trị viên hệ thống</p>
                </div>
            </aside>

            <main class="space-y-6">
                <header class="rounded-[28px] border border-slate-200 bg-white px-6 py-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Tổng quan hệ thống</p>
                            <h1 class="mt-3 text-3xl font-bold text-slate-900">Chào mừng trở lại, Quản trị viên</h1>
                        </div>
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <label class="relative block w-full sm:w-auto">
                                <span class="sr-only">Tìm kiếm</span>
                                <input type="search" placeholder="Tìm kiếm hội viên..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100" />
                                <span class="pointer-events-none absolute inset-y-0 right-4 inline-flex items-center text-slate-400">🔍</span>
                            </label>
                            <button class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-700">Check In</button>
                        </div>
                    </div>
                </header>

                <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <p class="text-sm font-semibold text-slate-500">Tổng Hội viên</p>
                        <h2 class="mt-4 text-3xl font-bold text-slate-900">2,408</h2>
                        <p class="mt-3 text-sm text-emerald-600">+5.2%</p>
                    </article>
                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <p class="text-sm font-semibold text-slate-500">Hội viên mới (Tháng)</p>
                        <h2 class="mt-4 text-3xl font-bold text-slate-900">125</h2>
                        <p class="mt-3 text-sm text-emerald-600">+12</p>
                    </article>
                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <p class="text-sm font-semibold text-slate-500">Doanh thu tháng (VND)</p>
                        <h2 class="mt-4 text-3xl font-bold text-slate-900">850M</h2>
                        <p class="mt-3 text-sm text-emerald-600">+8.4%</p>
                    </article>
                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-500">Lượt check-in</p>
                                <h2 class="mt-4 text-3xl font-bold text-slate-900">342</h2>
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
                                <svg viewBox="0 0 800 320" class="h-full w-full">
                                    <defs>
                                        <linearGradient id="chart-gradient" x1="0" x2="0" y1="0" y2="1">
                                            <stop offset="0%" stop-color="#2563eb" stop-opacity="0.35" />
                                            <stop offset="100%" stop-color="#93c5fd" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M50 220 C150 140 250 160 350 130 C450 100 550 120 650 90 C750 80 750 80 750 80" fill="none" stroke="#2563eb" stroke-width="5" stroke-linecap="round" />
                                    <path d="M50 220 C150 140 250 160 350 130 C450 100 550 120 650 90 C750 80 750 80 750 320 50 320 Z" fill="url(#chart-gradient)" opacity="0.9" />
                                    <circle cx="50" cy="220" r="7" fill="#2563eb" />
                                    <circle cx="150" cy="140" r="7" fill="#2563eb" />
                                    <circle cx="250" cy="160" r="7" fill="#2563eb" />
                                    <circle cx="350" cy="130" r="7" fill="#2563eb" />
                                    <circle cx="450" cy="100" r="7" fill="#2563eb" />
                                    <circle cx="550" cy="120" r="7" fill="#2563eb" />
                                    <circle cx="650" cy="90" r="7" fill="#2563eb" />
                                </svg>
                            </div>
                        </div>
                    </article>
                    <article class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)]">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Hoạt động mới</p>
                                <h2 class="mt-3 text-2xl font-bold text-slate-900">Xem tất cả</h2>
                            </div>
                            <button class="rounded-3xl bg-slate-100 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-slate-700">Xem tất cả</button>
                        </div>
                        <div class="space-y-4">
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-900">Nguyễn Văn A đã check-in</p>
                                <p class="mt-1 text-xs text-slate-500">Cơ sở Quận 1 • 2 phút trước</p>
                            </div>
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-900">Trần Thị B mua gói 12 tháng</p>
                                <p class="mt-1 text-xs text-slate-500">+12,000,000 VND • 15 phút trước</p>
                            </div>
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-900">Lê Hoàng C đăng ký hội viên mới</p>
                                <p class="mt-1 text-xs text-slate-500">Qua website • 1 giờ trước</p>
                            </div>
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-900">Máy chạy bộ #04 báo lỗi bảo trì</p>
                                <p class="mt-1 text-xs text-slate-500">Hệ thống IoT • 2 giờ trước</p>
                            </div>
                        </div>
                    </article>
                </section>
            </main>
        </div>
    </div>
</body>

</html>