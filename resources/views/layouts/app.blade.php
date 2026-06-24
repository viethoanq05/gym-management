<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gym Management')</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])

    <style>
        :root {
            --primary-color: #1662ff;
            --primary-dark: #0f4ed1;
            --accent-color: #ff7a1a;
            --text: #101828;
            --text-secondary: #667085;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --border: #e2e8f0;
            --bg-soft: #f4f7fb;
            --bg-white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(180deg, #f8fbff 0%, #eef3f8 100%);
            font-family: 'Manrope', sans-serif;
            color: var(--text);
        }

        .navbar {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.1);
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar .navbar-brand {
            font-weight: 800;
            font-size: 1.25rem;
            color: white !important;
            letter-spacing: 0.24em;
            text-transform: uppercase;
        }

        .navbar .nav-link {
            color: #ffffff !important;
            margin: 0 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: color 0.2s;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: #f0f4ff !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .sidebar {
            background: #F8FAFC;
            border-right: 1px solid #e2e8f0;
            min-height: calc(100vh - 70px);
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .sidebar .nav-link {
            color: #667085 !important;
            padding: 0.75rem 1rem;
            margin: 0.5rem 0.75rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar .nav-link:hover {
            background: transparent;
            color: #667085 !important;
            opacity: 0.7;
        }

        .sidebar .nav-link.active {
            background: #e0e9f8;
            color: #1662ff !important;
            box-shadow: none;
        }

        .sidebar .nav-link i {
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            padding: 2rem;
            background: transparent;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        }

        .page-header h2 {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            margin-bottom: 0;
        }

        .card {
            border: none;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            transition: all 0.2s;
            border: 1px solid var(--border);
            background: var(--bg-white);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        }

        .table-responsive {
            border-radius: 1rem;
            overflow: hidden;
        }

        .btn {
            border-radius: 0.75rem;
            font-weight: 600;
            font-family: 'Manrope', sans-serif;
            transition: all 0.2s;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(22, 98, 255, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), #083db0);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(22, 98, 255, 0.35);
        }

        .btn-secondary {
            background: var(--bg-soft);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--border);
        }

        .btn-success {
            background: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-warning {
            background: var(--warning-color);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .footer {
            background: #23262f;
            color: #cbd5e1;
            padding: 2rem;
            text-align: center;
            margin-top: 2rem;
            font-size: 0.875rem;
        }

        .alert {
            border-radius: 1rem;
            border: 1px solid var(--border);
            background: white;
            color: var(--text);
            padding: 1.25rem;
        }

        .alert-success {
            border-color: var(--success-color);
            background: rgba(16, 185, 129, 0.05);
            color: var(--success-color);
        }

        .alert-danger {
            border-color: var(--danger-color);
            background: rgba(239, 68, 68, 0.05);
            color: var(--danger-color);
        }

        .alert-info {
            border-color: var(--primary-color);
            background: rgba(22, 98, 255, 0.05);
            color: var(--primary-color);
        }

        .table {
            border-radius: 0.75rem;
            overflow: hidden;
            font-size: 0.875rem;
        }

        .table thead th {
            background: var(--bg-soft);
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: 1px solid var(--border);
            padding: 1rem;
        }

        .table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.2s;
        }

        .table tbody tr:hover {
            background: var(--bg-soft);
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .badge {
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success-color);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger-color);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning-color);
        }

        .badge-info {
            background: rgba(22, 98, 255, 0.15);
            color: var(--primary-color);
        }

        .table-light {
            background: var(--bg-soft) !important;
        }

        @media (max-width: 1024px) {
            .main-content {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .col-lg-10,
            .col-lg-2 {
                max-width: 100% !important;
                flex: 0 0 100% !important;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-dumbbell"></i> Gym Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="fas fa-user"></i> {{ auth()->user()->name }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link bg-transparent border-0" style="cursor: pointer;">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            @if(auth()->check() && auth()->user()->role == 'trainer')
            <!-- Trainer Sidebar -->
            <div class="col-lg-2 sidebar">
                <div class="nav flex-column nav-pills pt-3">
                    <a class="nav-link @if(Route::current()->getName() == 'trainer.dashboard') active @endif" href="{{ route('trainer.dashboard') }}">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                    <a class="nav-link @if(Route::current()->getName() == 'trainer.schedule.bookings') active @endif" href="{{ route('trainer.schedule.bookings') }}">
                        <i class="fas fa-calendar-check"></i> Lịch đặt
                    </a>
                    <a class="nav-link @if(Route::current()->getName() == 'trainer.schedule.index') active @endif" href="{{ route('trainer.schedule.index') }}">
                        <i class="fas fa-clock"></i> Lịch làm việc
                    </a>
                    <a class="nav-link @if(Route::current()->getName() == 'trainer.members.index') active @endif" href="{{ route('trainer.members.index') }}">
                        <i class="fas fa-users"></i> Hội viên
                    </a>
                </div>
            </div>

            <!-- Page Content -->
            <div class="col-lg-10 main-content">
                @yield('content')
            </div>
            @else
                <div class="col-12 main-content">
                    @yield('content')
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} Gym Management System. All rights reserved.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>
