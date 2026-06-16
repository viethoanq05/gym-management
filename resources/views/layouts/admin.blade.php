<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') | Gym Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="flex min-h-screen">
        <aside id="sidebarMenu" class="hidden lg:block w-72 h-screen flex-shrink-0 bg-slate-900 text-white">
            <div class="flex h-full flex-col px-5 py-6 overflow-y-auto">
                <div class="mb-8 flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-600 text-xl font-bold text-white">G</div>
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Gym Management</p>
                        <h1 class="text-xl font-semibold text-white">Admin Panel</h1>
                    </div>
                </div>

                <x-admin.sidebar />
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="w-full flex justify-between items-center px-6 py-4 bg-white border-b">
                <div class="flex items-center gap-3">
                    <button id="sidebarToggle"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 lg:hidden">
                        <span class="sr-only">Mở menu</span>
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="relative w-full max-w-xl">
                        <span class="pointer-events-none absolute inset-y-0 left-4 inline-flex items-center text-slate-400">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="M21 21l-4.35-4.35" />
                            </svg>
                        </span>
                        <input type="search" name="search" placeholder="Tìm kiếm..."
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </div>
                </div>

                <div>
                    <x-admin.topbar />
                </div>
            </header>

            <main class="flex-1 overflow-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebarMenu');
            button?.addEventListener('click', function() {
                sidebar?.classList.toggle('hidden');
            });
        });
    </script>

    @stack('scripts')
</body>

</html>