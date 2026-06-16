<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký thành viên - IRON CORE</title>

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

<body class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-md p-6">
        <div class="rounded-xl bg-white p-8 shadow-xl">
            <div class="mb-6 text-center">
                <div class="mb-2 inline-flex items-center gap-2 text-[var(--brand,#1662ff)]">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="inline-block">
                        <path d="M3 12h18" stroke="#1662ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="font-extrabold text-lg">IRON CORE</span>
                </div>
                <h1 class="text-2xl font-extrabold">Đăng ký thành viên</h1>
                <p class="mt-1 text-sm text-slate-500 font-medium">Tạo tài khoản nhanh chóng để tham gia tập luyện.</p>
            </div>

            <form method="POST" action="{{ route('member.register.store') }}" class="space-y-4">
                @csrf

                <!-- Họ và tên -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-600">Họ và tên</label>
                    <input name="name" value="{{ old('name') }}" type="text" required class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand,#1662ff)]" placeholder="Nguyễn Văn A">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-600">Email</label>
                    <input name="email" value="{{ old('email') }}" type="email" required class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand,#1662ff)]" placeholder="nhap.email@vidu.com">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Số điện thoại -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-600">Số điện thoại</label>
                    <input name="phone" value="{{ old('phone') }}" type="text" required class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand,#1662ff)]" placeholder="0901234567">
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Mật khẩu -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-600">Mật khẩu</label>
                    <div class="relative">
                        <input name="password" type="password" required class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand,#1662ff)]" placeholder="••••••••">
                        <button type="button" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 transition" onclick="
                            const input = this.previousElementSibling;
                            input.type = input.type === 'password' ? 'text' : 'password';
                        ">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Xác nhận mật khẩu -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-600">Xác nhận mật khẩu</label>
                    <div class="relative">
                        <input name="password_confirmation" type="password" required class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand,#1662ff)]" placeholder="••••••••">
                        <button type="button" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 transition" onclick="
                            const input = this.previousElementSibling;
                            input.type = input.type === 'password' ? 'text' : 'password';
                        ">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full rounded-md bg-[var(--brand,#1662ff)] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-blue-700">Đăng ký →</button>
                </div>

                <p class="pt-2 text-center text-sm text-slate-500">Đã có tài khoản? <a href="{{ route('login') }}" class="text-[var(--brand,#1662ff)] font-medium hover:underline">Đăng nhập ngay</a></p>
            </form>
        </div>
    </div>
</body>

</html>