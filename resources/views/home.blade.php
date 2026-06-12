<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="IRON CORE GYM - Nâng tầm thể chất, khơi nguồn sức mạnh.">
    <title>IRON CORE GYM</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(22, 98, 255, 0.08), transparent 28%),
                radial-gradient(circle at top right, rgba(255, 122, 26, 0.08), transparent 24%),
                linear-gradient(180deg, #f8fbff 0%, #eef3f8 100%);
        }

        .hero-image {
            background-image:
                linear-gradient(180deg, rgba(8, 18, 44, 0.20), rgba(8, 18, 44, 0.40)),
                url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }

        .card-glow {
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        }

        .section-title {
            letter-spacing: -0.03em;
        }

        .soft-grid {
            background-image:
                linear-gradient(rgba(255, 255, 255, .36) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .36) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>

<body class="min-h-screen text-slate-900">
    <div class="mx-auto flex min-h-screen max-w-[1180px] flex-col px-4 py-4 sm:px-6 lg:px-8">
        <header class="rounded-2xl border border-white/70 bg-white/90 px-4 py-3 shadow-[0_10px_40px_rgba(15,23,42,0.08)] backdrop-blur md:px-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="text-base font-extrabold tracking-[0.24em] text-[var(--brand)]">IRON CORE</div>
                    <div class="text-[11px] font-medium uppercase tracking-[0.28em] text-slate-400">Gym & Fitness</div>
                </div>

                <nav class="hidden items-center gap-8 text-sm font-semibold text-slate-600 md:flex">
                    <a class="text-[var(--brand)]" href="#home">Trang chủ</a>
                    <a class="transition hover:text-[var(--brand)]" href="#services">Dịch vụ</a>
                    <a class="transition hover:text-[var(--brand)]" href="#offers">Gói tập</a>
                    <a class="transition hover:text-[var(--brand)]" href="#trainer">PT</a>
                    <a class="transition hover:text-[var(--brand)]" href="#contact">Liên hệ</a>
                </nav>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/admin/dashboard') }}" class="rounded-xl bg-[var(--brand)] px-4 py-2 text-sm font-bold text-white transition hover:bg-[var(--brand-strong)]">Bảng điều khiển</a>
                    @else
                    <a href="{{ route('login') }}" class="rounded-xl bg-[var(--brand)] px-4 py-2 text-sm font-bold text-white transition hover:bg-[var(--brand-strong)]">Đăng nhập</a>
                    @endauth
                    @endif
                </div>
            </div>
        </header>

        <main id="home" class="flex-1">
            <section class="mt-4 overflow-hidden rounded-[28px] border border-blue-100 bg-white shadow-[0_25px_70px_rgba(15,23,42,0.12)]">
                <div class="hero-image relative min-h-[430px] px-6 py-10 sm:px-10 sm:py-14 lg:px-16 lg:py-20">
                    <div class="absolute inset-0 soft-grid opacity-20"></div>
                    <div class="relative mx-auto flex max-w-3xl flex-col items-center text-center text-white">
                        <span class="mb-4 inline-flex rounded-full border border-white/30 bg-white/10 px-4 py-1 text-xs font-bold uppercase tracking-[0.26em] text-white/90">IRON CORE GYM</span>
                        <h1 class="section-title max-w-4xl text-4xl font-extrabold uppercase leading-tight sm:text-5xl lg:text-6xl">
                            Nâng tầm thể chất - Khơi nguồn sức mạnh
                        </h1>
                        <p class="mt-5 max-w-2xl text-sm leading-7 text-white/88 sm:text-base">
                            Trải nghiệm không gian tập luyện hiện đại, huấn luyện chuyên nghiệp và lộ trình cá nhân hóa giúp bạn bứt phá mỗi ngày.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                            <a href="#offers" class="rounded-xl bg-[var(--accent)] px-7 py-3 text-sm font-extrabold text-white shadow-lg shadow-orange-500/25 transition hover:-translate-y-0.5 hover:bg-[#eb6a10]">Đăng ký ngay</a>
                            <a href="#services" class="rounded-xl border border-white/30 bg-white/10 px-7 py-3 text-sm font-bold text-white backdrop-blur transition hover:bg-white/20">Khám phá</a>
                        </div>
                    </div>
                </div>

                <div id="services" class="bg-[var(--soft)] px-6 py-14 sm:px-10 lg:px-16">
                    <div class="mx-auto max-w-6xl">
                        <div class="text-center">
                            <h2 class="section-title text-3xl font-extrabold text-[var(--brand)]">Khu Vực Tập Luyện</h2>
                            <p class="mt-3 text-sm text-[var(--muted)]">Không gian đa dạng đáp ứng mọi nhu cầu thể hình của bạn.</p>
                        </div>

                        <div class="mt-10 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                            @php
                            $areas = [
                            ['title' => 'Gym Khu Vực', 'desc' => 'Trang thiết bị tối tân và máy tập hiện đại chuẩn 100%.', 'icon' => 'M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm0 4a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2H9a1 1 0 1 1 0-2h2V7a1 1 0 0 1 1-1Z'],
                            ['title' => 'Yoga Studio', 'desc' => 'Không gian yên tĩnh, ấm áp, tập trung vào sức khỏe toàn diện.', 'icon' => 'M12 3c1.66 0 3 1.34 3 3 0 1.45-1.03 2.66-2.4 2.94V11h2.9c.83 0 1.5.67 1.5 1.5S16.33 14 15.5 14H13v5h2a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2h2v-5H8.5c-.83 0-1.5-.67-1.5-1.5S7.67 11 8.5 11h2.9V8.94C10.03 8.66 9 7.45 9 6c0-1.66 1.34-3 3-3Z'],
                            ['title' => 'Boxing Ring', 'desc' => 'Trang bị đầy đủ, phù hợp cho tập luyện đối kháng chuyên sâu.', 'icon' => 'M7 6h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm0 2v8h10V8H7Zm2 2h6v2H9v-2Z'],
                            ['title' => 'Hồ Bơi 4 Mùa', 'desc' => 'Hồ bơi trong nhà điều chỉnh nhiệt độ, an toàn và sạch sẽ.', 'icon' => 'M4 14c1.6 0 2.4-1 3.2-1 .8 0 1.6 1 3.2 1s2.4-1 3.2-1c.8 0 1.6 1 3.2 1s2.4-1 3.2-1a1 1 0 1 1 0 2c-1.6 0-2.4 1-3.2 1s-1.6-1-3.2-1-2.4 1-3.2 1-1.6-1-3.2-1-1.6 1-3.2 1a1 1 0 1 1 0-2Z'],
                            ];
                            @endphp

                            @foreach ($areas as $area)
                            <article class="card-glow rounded-2xl border border-white bg-white p-5 transition hover:-translate-y-1">
                                <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-full bg-blue-50 text-[var(--brand)]">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                                        <path d="{{ $area['icon'] }}"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-extrabold text-slate-900">{{ $area['title'] }}</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-500">{{ $area['desc'] }}</p>
                            </article>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div id="offers" class="bg-white px-6 py-14 sm:px-10 lg:px-16">
                    <div class="mx-auto max-w-6xl">
                        <div class="text-center">
                            <h2 class="section-title text-3xl font-extrabold text-[var(--brand)]">Gói Tập Ưu Đãi</h2>
                            <p class="mt-3 text-sm text-[var(--muted)]">Lựa chọn gói tập phù hợp với mục tiêu của bạn.</p>
                        </div>

                        <div class="mt-10 grid gap-6 lg:grid-cols-3">
                            <article class="card-glow rounded-[28px] border border-slate-200 bg-white p-7">
                                <p class="text-lg font-bold text-slate-900">Cơ Bản</p>
                                <div class="mt-4 flex items-end gap-1">
                                    <span class="text-4xl font-extrabold text-slate-900">500k</span>
                                    <span class="pb-1 text-sm font-semibold text-slate-500">/tháng</span>
                                </div>
                                <ul class="mt-6 space-y-3 text-sm text-slate-600">
                                    <li>• Sử dụng khu vực Gym</li>
                                    <li>• Tham gia lớp tập Yoga cơ bản</li>
                                    <li>• Gửi xe miễn phí</li>
                                </ul>
                                <a href="#contact" class="mt-8 inline-flex w-full items-center justify-center rounded-xl border border-[var(--brand)] px-5 py-3 text-sm font-bold text-[var(--brand)] transition hover:bg-blue-50">Chọn gói này</a>
                            </article>

                            <article class="card-glow relative rounded-[28px] border-2 border-[var(--brand)] bg-white p-7">
                                <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-[var(--brand)] px-4 py-1 text-xs font-bold uppercase tracking-[0.24em] text-white">Bán chạy nhất</span>
                                <p class="text-lg font-bold text-slate-900">Nâng Cao</p>
                                <div class="mt-4 flex items-end gap-1">
                                    <span class="text-4xl font-extrabold text-[var(--brand)]">800k</span>
                                    <span class="pb-1 text-sm font-semibold text-slate-500">/tháng</span>
                                </div>
                                <ul class="mt-6 space-y-3 text-sm text-slate-600">
                                    <li>• Toàn quyền sử dụng Gym & Boxing</li>
                                    <li>• Tất cả lớp tập Yoga & Group X</li>
                                    <li>• Khăn tắm miễn phí</li>
                                    <li>• 1 buổi PT định hướng</li>
                                </ul>
                                <a href="#contact" class="mt-8 inline-flex w-full items-center justify-center rounded-xl bg-[var(--brand)] px-5 py-3 text-sm font-bold text-white transition hover:bg-[var(--brand-strong)]">Chọn gói này</a>
                            </article>

                            <article class="card-glow rounded-[28px] border border-orange-200 bg-white p-7">
                                <p class="text-lg font-bold text-slate-900">Premium</p>
                                <div class="mt-4 flex items-end gap-1">
                                    <span class="text-4xl font-extrabold text-[var(--accent)]">1.2M</span>
                                    <span class="pb-1 text-sm font-semibold text-slate-500">/tháng</span>
                                </div>
                                <ul class="mt-6 space-y-3 text-sm text-slate-600">
                                    <li>• Full quyền truy cập mọi khu vực</li>
                                    <li>• 10 buổi PT hằng tháng</li>
                                    <li>• Nước uống tháo tác miễn phí</li>
                                    <li>• Đăng ký bảo hộ riêng</li>
                                </ul>
                                <a href="#contact" class="mt-8 inline-flex w-full items-center justify-center rounded-xl border border-[var(--accent)] px-5 py-3 text-sm font-bold text-[var(--accent)] transition hover:bg-orange-50">Chọn gói này</a>
                            </article>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer id="contact" class="mt-4 rounded-2xl bg-[#23262f] px-6 py-8 text-slate-200 shadow-[0_20px_50px_rgba(15,23,42,0.18)] sm:px-10 lg:px-14">
            <div class="grid gap-10 md:grid-cols-3 md:gap-8">
                <div>
                    <h3 class="text-lg font-extrabold tracking-[0.18em] text-white">IRON CORE GYM</h3>
                    <p class="mt-4 max-w-sm text-sm leading-7 text-slate-400">
                        Hệ thống phòng tập cao cấp, mang đến trải nghiệm luyện tập hiện đại, chuyên nghiệp và bền vững cho cộng đồng.
                    </p>
                </div>

                <div>
                    <h4 class="text-base font-bold text-white">Liên hệ</h4>
                    <ul class="mt-4 space-y-3 text-sm text-slate-400">
                        <li>175 Tây Sơn, Kim Liên, Hà Nội</li>
                        <li>0123.456.789</li>
                        <li>contact@ironcore.vn</li>
                    </ul>
                </div>

                <div class="md:text-right">
                    @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="inline-flex rounded-xl bg-[var(--brand)] px-5 py-3 text-sm font-bold text-white transition hover:bg-[var(--brand-strong)]">Đăng nhập hội viên</a>
                    @endif
                    <p class="mt-4 text-xs text-slate-500">© 2024 Iron Core Gym. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>