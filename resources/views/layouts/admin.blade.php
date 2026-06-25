<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') | Gym Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-slate-200 antialiased" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">
    <div x-data="{ sidebarOpen: false, init() { window.addEventListener('resize', () => { if (window.innerWidth < 1024) this.sidebarOpen = false }) } }" class="flex h-screen overflow-hidden">
        <!-- Overlay backdrop for mobile -->
        <div x-show="sidebarOpen" x-cloak x-transition.opacity class="fixed inset-0 z-20 bg-slate-950/70 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        @include('components.admin.sidebar')

        <!-- Main content -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden admin-scrollbar" style="background: linear-gradient(135deg, #0f172a 0%, #0c1425 50%, #0f172a 100%);">
            @include('components.admin.topbar')

            <main class="w-full grow p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                <div class="mb-6 toast-enter toast-success rounded-xl p-4 flex items-center gap-3" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg gradient-success flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <span class="flex-1 text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="text-emerald-400/60 hover:text-emerald-300 transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 toast-enter toast-error rounded-xl p-4 flex items-center gap-3" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg gradient-danger flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>
                    </div>
                    <span class="flex-1 text-sm font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="text-red-400/60 hover:text-red-300 transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 toast-enter toast-error rounded-xl p-4" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg gradient-danger flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </div>
                        <span class="flex-1 text-sm font-semibold">Có lỗi xảy ra:</span>
                        <button @click="show = false" class="text-red-400/60 hover:text-red-300 transition">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <ul class="ml-11 list-disc list-inside space-y-1 text-sm text-red-300/90">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @stack('scripts')
</body>

</html>