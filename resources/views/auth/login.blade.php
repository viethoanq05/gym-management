<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập - IRON CORE GYM</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --brand: #1662ff;
            --brand-strong: #0f4ed1;
            --accent: #ff7a1a;
            --text: #101828;
            --muted: #667085;
            --surface: #ffffff;
            --soft: #f4f7fb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: linear-gradient(135deg, #f8fbff 0%, #eef3f8 100%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: white;
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.12);
            border: 1px solid rgba(22, 98, 255, 0.08);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-section {
            margin-bottom: 1.5rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 0.24em;
            color: var(--brand);
            margin-bottom: 0.5rem;
        }

        .logo-sub {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.28em;
            color: #cbd5e1;
        }

        .login-title {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 0.5rem;
            letter-spacing: -0.03em;
        }

        .login-subtitle {
            font-size: 0.875rem;
            color: var(--muted);
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            font-family: 'Manrope', sans-serif;
            font-size: 0.875rem;
            color: var(--text);
            transition: all 0.2s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(22, 98, 255, 0.1);
        }

        input::placeholder {
            color: #cbd5e1;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 1rem;
            padding: 0.5rem;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            cursor: pointer;
            accent-color: var(--brand);
        }

        .checkbox-wrapper label {
            margin: 0;
            font-weight: 500;
            cursor: pointer;
        }

        .forgot-password {
            color: var(--brand);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: var(--brand-strong);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem 1.25rem;
            background: linear-gradient(135deg, var(--brand), var(--brand-strong));
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 700;
            font-family: 'Manrope', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(22, 98, 255, 0.2);
            letter-spacing: 0.03em;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(22, 98, 255, 0.3);
        }

        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: var(--muted);
        }

        .signup-link a {
            color: var(--brand);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.2s;
        }

        .signup-link a:hover {
            color: var(--accent);
        }

        @media (max-width: 640px) {
            .login-card {
                padding: 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-section">
                    <div class="logo">IRON CORE</div>
                    <div class="logo-sub">GYM & FITNESS</div>
                </div>
                <h1 class="login-title">Đăng Nhập</h1>
                <p class="login-subtitle">Chào mừng trở lại. Vui lòng nhập thông tin để tiếp tục.</p>
            </div>

            <form method="POST" action="{{ route('login.perform') }}">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="your.email@example.com" required>
                    @error('email')
                    <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
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
                    @error('password')
                    <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="remember">
                        <span>Ghi nhớ đăng nhập</span>
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">Quên mật khẩu?</a>
                    @endif
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn-submit"><i class="fas fa-sign-in-alt"></i> Đăng Nhập</button>
                </div>



                <p class="mt-4 text-center text-sm text-slate-500">Chưa có tài khoản? <a href="{{ route('member.register.form') }}" class="text-[var(--brand,#1662ff)]">Đăng ký tài khoản mới</a></p>
            </form>


        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const btn = document.querySelector('.toggle-password');
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                input.type = 'password';
                btn.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
</body>

</html>