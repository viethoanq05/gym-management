<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập - IRON CORE</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
            background: #f7f7f9;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center">
    <div class="mx-auto w-full max-w-md p-6">
        <div class="rounded-xl bg-white p-8 shadow-xl">
            <div class="mb-6 text-center">
                <div class="mb-2 inline-flex items-center gap-2 text-[var(--brand,#1662ff)]">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="inline-block">
                        <path d="M3 12h18" stroke="#1662ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="font-extrabold text-lg">IRON CORE</span>
                </div>
                <h1 class="text-2xl font-extrabold">Đăng nhập</h1>
                <p class="mt-1 text-sm text-slate-500">Chào mừng trở lại. Vui lòng nhập thông tin để tiếp tục.</p>
            </div>

            <form method="POST" action="{{ route('login.perform') }}">
                @csrf

                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-slate-600">Email</label>
                    <input name="email" value="{{ old('email') }}" type="email" required class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand,#1662ff)]" placeholder="nhap.email@vidu.com">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-slate-600">Mật khẩu</label>
                    <div class="relative">
                        <input name="password" type="password" required class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand,#1662ff)]" placeholder="••••••••">
                        <button type="button" class="absolute right-2 top-2 text-slate-400" onclick="(this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password')">👁️</button>
                    </div>
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4 flex items-center justify-between text-sm">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300"> <span>Ghi nhớ đăng nhập</span>
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-[var(--brand,#1662ff)]">Quên mật khẩu?</a>
                    @endif
                </div>

                <div class="mb-4">
                    <button type="submit" class="w-full rounded-md bg-[var(--brand,#1662ff)] px-4 py-2 text-sm font-bold text-white">Đăng nhập →</button>
                </div>

                

                <p class="mt-4 text-center text-sm text-slate-500">Chưa có tài khoản? <a href="#" class="text-[var(--brand,#1662ff)]">Đăng ký tài khoản mới</a></p>
            </form>
        </div>
    </div>
</body>

</html>