<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gym Management')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .navbar .nav-link:hover {
            color: #fff !important;
        }

        .navbar .nav-link.active {
            color: #fff !important;
            border-bottom: 3px solid #fff;
        }

        .sidebar {
            background-color: white;
            border-right: 1px solid #dee2e6;
            min-height: 100vh;
        }

        .sidebar .nav-link {
            color: #2c3e50;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: #f0f0f0;
            color: var(--primary-color);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .main-content {
            padding: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .btn {
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 40px;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
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
