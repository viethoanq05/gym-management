<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') | Gym Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 font-sans antialiased">
    <div x-data="{ sidebarOpen: false, init() { window.addEventListener('resize', () => { if (window.innerWidth < 1024) this.sidebarOpen = false }) } }" class="flex h-screen overflow-hidden bg-slate-50">
        <!-- Overlay backdrop for mobile -->
        <div x-show="sidebarOpen" x-cloak x-transition.opacity class="fixed inset-0 z-20 bg-slate-900/50 lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        @include('components.admin.sidebar')

        <!-- Main content -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            @include('components.admin.topbar')

            <main class="w-full grow p-4 sm:p-6">
                @if(session('success'))
                <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-4 text-red-800">
                    {{ session('error') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-700">
                    <div class="font-semibold">Có lỗi xảy ra:</div>
                    <ul class="mt-2 list-disc list-inside space-y-1">
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