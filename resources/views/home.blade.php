<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="IRON CORE GYM - Nâng tầm thể chất, khơi nguồn sức mạnh.">
    <title>IRON CORE GYM</title>

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

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background: linear-gradient(180deg, #f8fbff 0%, #eef3f8 100%);
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08);
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .logo-title {
            font-size: 1.125rem;
            font-weight: 800;
            letter-spacing: 0.24em;
            color: var(--brand);
        }

        .logo-subtitle {
            font-size: 0.6875rem;
            font-weight: 500;
            letter-spacing: 0.28em;
            color: #cbd5e1;
        }

        nav {
            display: none;
            gap: 2rem;
            align-items: center;
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
        }

        nav a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s;
        }

        nav a:hover {
            color: var(--brand);
        }

        @media (min-width: 768px) {
            nav {
                display: flex;
            }
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--brand);
            color: white;
        }

        .btn-primary:hover {
            background: var(--brand-strong);
        }

        .hero {
            background: linear-gradient(180deg, rgba(8, 18, 44, 0.2), rgba(8, 18, 44, 0.4)),
                        url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 4rem 1.5rem;
            text-align: center;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            padding: 0.25rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.26em;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.25rem;
            letter-spacing: -0.03em;
        }

        @media (min-width: 768px) {
            .hero h1 {
                font-size: 3.5rem;
            }
        }

        .hero p {
            font-size: 1rem;
            line-height: 1.75;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 0.75rem 1.75rem;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .btn-cta {
            background: var(--accent);
            color: white;
            padding: 0.75rem 1.75rem;
            box-shadow: 0 8px 25px rgba(255, 122, 26, 0.25);
        }

        .btn-cta:hover {
            background: #eb6a10;
            transform: translateY(-2px);
        }

        section {
            width: 100%;
            padding: 3.5rem 1.5rem;
        }

        .section-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 1.875rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            color: var(--text);
            letter-spacing: -0.03em;
        }

        .section-subtitle {
            font-size: 0.875rem;
            color: var(--muted);
        }

        #services {
            background: var(--soft);
        }

        .grid-services {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .service-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            transition: all 0.2s;
        }

        .service-card:hover {
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.1);
            transform: translateY(-4px);
        }

        .service-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--brand), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .service-card h3 {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text);
        }

        .service-card p {
            font-size: 0.875rem;
            color: var(--muted);
            line-height: 1.6;
        }

        #pricing {
            background: white;
        }

        .grid-pricing {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .pricing-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.08);
            transition: all 0.3s;
            position: relative;
        }

        .pricing-card:hover {
            box-shadow: 0 15px 40px rgba(15, 23, 42, 0.15);
            transform: translateY(-8px);
        }

        .pricing-card.featured {
            border: 2px solid var(--brand);
            background: linear-gradient(135deg, rgba(22, 98, 255, 0.05), rgba(22, 98, 255, 0.02));
        }

        .pricing-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--brand);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .pricing-name {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 1rem;
        }

        .pricing-price {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--brand);
            margin-bottom: 0.25rem;
        }

        .pricing-period {
            font-size: 0.875rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .pricing-features {
            list-style: none;
            margin-bottom: 2rem;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem 0;
        }

        .pricing-features li {
            font-size: 0.875rem;
            color: var(--text);
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .pricing-features li:before {
            content: "✓";
            color: var(--brand);
            font-weight: 700;
            font-size: 1.125rem;
        }

        .pricing-btn {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--brand);
            background: white;
            color: var(--brand);
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pricing-card.featured .pricing-btn {
            background: var(--brand);
            color: white;
        }

        .pricing-btn:hover {
            background: var(--brand);
            color: white;
        }

        footer {
            background: #23262f;
            color: #cbd5e1;
            padding: 2rem 1.5rem;
            margin-top: auto;
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-col h3 {
            color: white;
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: 0.18em;
        }

        .footer-col p {
            font-size: 0.875rem;
            line-height: 1.7;
            color: #94a3b8;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            color: #94a3b8;
        }

        .footer-col a {
            color: var(--brand);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-col a:hover {
            color: var(--accent);
        }

        .footer-bottom {
            border-top: 1px solid #334155;
            padding-top: 2rem;
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 0.75rem 1rem;
            }

            .hero {
                padding: 2rem 1rem;
                min-height: 350px;
            }

            .hero h1 {
                font-size: 1.875rem;
            }

            section {
                padding: 2rem 1rem;
            }

            .grid-services {
                grid-template-columns: 1fr;
            }

            .grid-pricing {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="header-container">
                <a href="/" class="logo">
                    <div>
                        <div class="logo-title">IRON CORE</div>
                        <div class="logo-subtitle">GYM & FITNESS</div>
                    </div>
                </a>

                <nav>
                    <a href="#services">Dịch vụ</a>
                    <a href="#pricing">Gói tập</a>
                    <a href="#contact">Liên hệ</a>
                </nav>

                <div class="header-actions">
                    @if(auth()->check())
                        <span style="color: var(--text); font-weight: 600;">{{ auth()->user()->name }}</span>
                        <a href="{{ route('trainer.dashboard') }}" class="btn btn-primary">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">Đăng Xuất</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Đăng Nhập</a>
                    @endif
                </div>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="hero-content">
                    <div class="hero-badge">IRON CORE GYM</div>
                    <h1>🏋️ Nâng Tầm Thể Chất</h1>
                    <p>Khơi nguồn sức mạnh với các chương trình tập luyện chuyên nghiệp, huấn luyện viên hàng đầu và công nghệ hiện đại.</p>
                    @if(!auth()->check())
                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn btn-cta">Đăng Nhập</a>
                        <a href="#services" class="btn btn-secondary">Khám Phá</a>
                    </div>
                    @endif
                </div>
            </section>

            <section id="services">
                <div class="section-container">
                    <div class="section-header">
                        <h2 class="section-title">Tính Năng Chính</h2>
                        <p class="section-subtitle">Tất cả những gì bạn cần để đạt mục tiêu fitness</p>
                    </div>

                    <div class="grid-services">
                        <div class="service-card">
                            <i class="fas fa-chart-line service-icon"></i>
                            <h3>Dashboard</h3>
                            <p>Theo dõi tiến độ tập luyện, điểm số và thành tích một cách chi tiết.</p>
                        </div>
                        <div class="service-card">
                            <i class="fas fa-calendar service-icon"></i>
                            <h3>Quản Lý Lịch</h3>
                            <p>Đặt lịch tập, quản lý thời gian với huấn luyện viên linh hoạt.</p>
                        </div>
                        <div class="service-card">
                            <i class="fas fa-users service-icon"></i>
                            <h3>Hỗ Trợ PT</h3>
                            <p>Các huấn luyện viên chuyên nghiệp sẵn sàng giúp bạn đạt mục tiêu.</p>
                        </div>
                        <div class="service-card">
                            <i class="fas fa-heartbeat service-icon"></i>
                            <h3>Theo Dõi Sức Khỏe</h3>
                            <p>Quản lý chỉ số sức khỏe, cân nặng, chiều cao và tiến độ cải thiện.</p>
                        </div>
                        <div class="service-card">
                            <i class="fas fa-star service-icon"></i>
                            <h3>Hệ Thống Điểm</h3>
                            <p>Nhận điểm thưởng, cạnh tranh lành mạnh và có động lực tập luyện.</p>
                        </div>
                        <div class="service-card">
                            <i class="fas fa-mobile-alt service-icon"></i>
                            <h3>Truy Cập Di Động</h3>
                            <p>Truy cập mọi lúc, mọi nơi qua thiết bị di động hoặc máy tính.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pricing">
                <div class="section-container">
                    <div class="section-header">
                        <h2 class="section-title">Gói Tập Ưu Đãi</h2>
                        <p class="section-subtitle">Lựa chọn gói tập phù hợp với mục tiêu của bạn</p>
                    </div>

                    <div class="grid-pricing">
                        <div class="pricing-card">
                            <h3 class="pricing-name">Cơ Bản</h3>
                            <div class="pricing-price">500k</div>
                            <div class="pricing-period">/tháng</div>
                            <ul class="pricing-features">
                                <li>Sử dụng khu vực Gym</li>
                                <li>Lớp tập Yoga cơ bản</li>
                                <li>Gửi xe miễn phí</li>
                            </ul>
                            @if(!auth()->check())
                            <a href="{{ route('login') }}" class="pricing-btn">Chọn Gói</a>
                            @else
                            <button class="pricing-btn" disabled>Đã Đăng Nhập</button>
                            @endif
                        </div>

                        <div class="pricing-card featured">
                            <div class="pricing-badge">Bán Chạy Nhất</div>
                            <h3 class="pricing-name">Nâng Cao</h3>
                            <div class="pricing-price">800k</div>
                            <div class="pricing-period">/tháng</div>
                            <ul class="pricing-features">
                                <li>Toàn quyền Gym & Boxing</li>
                                <li>Lớp Yoga & Group X</li>
                                <li>Khăn tắm miễn phí</li>
                                <li>1 buổi PT định hướng</li>
                            </ul>
                            @if(!auth()->check())
                            <a href="{{ route('login') }}" class="pricing-btn">Chọn Gói</a>
                            @else
                            <button class="pricing-btn" disabled>Đã Đăng Nhập</button>
                            @endif
                        </div>

                        <div class="pricing-card">
                            <h3 class="pricing-name">Premium</h3>
                            <div class="pricing-price">1.2M</div>
                            <div class="pricing-period">/tháng</div>
                            <ul class="pricing-features">
                                <li>Full quyền mọi khu vực</li>
                                <li>10 buổi PT/tháng</li>
                                <li>Nước uống miễn phí</li>
                                <li>Đăng ký bảo hộ riêng</li>
                            </ul>
                            @if(!auth()->check())
                            <a href="{{ route('login') }}" class="pricing-btn">Chọn Gói</a>
                            @else
                            <button class="pricing-btn" disabled>Đã Đăng Nhập</button>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer id="contact">
            <div class="footer-container">
                <div class="footer-grid">
                    <div class="footer-col">
                        <h3>IRON CORE GYM</h3>
                        <p>Hệ thống phòng tập cao cấp, mang đến trải nghiệm luyện tập hiện đại, chuyên nghiệp và bền vững cho cộng đồng.</p>
                    </div>
                    <div class="footer-col">
                        <h3>Liên Hệ</h3>
                        <ul>
                            <li>📍 175 Tây Sơn, Kim Liên, Hà Nội</li>
                            <li>📞 0123.456.789</li>
                            <li>📧 contact@ironcore.vn</li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h3>Truy Cập</h3>
                        <ul>
                            <li><a href="{{ route('login') }}">Đăng Nhập</a></li>
                            <li><a href="#services">Dịch Vụ</a></li>
                            <li><a href="#pricing">Gói Tập</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; 2024 Iron Core Gym. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
