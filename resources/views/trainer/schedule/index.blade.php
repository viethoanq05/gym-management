<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lịch Làm Việc - IRON CORE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/js/app.js'])
</head>

<body>
    <div class="app-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">IC</div>
                <div class="sidebar-logo-text">
                    <div class="sidebar-logo-brand">Iron Core</div>
                    <div class="sidebar-logo-subtext">Premium Management</div>
                </div>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('trainer.dashboard') }}" class="sidebar-menu-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('trainer.schedule.index') }}" class="sidebar-menu-item active">
                    <i class="fas fa-calendar"></i>
                    <span>Lịch Làm Việc</span>
                </a>
                <a href="{{ route('trainer.schedule.bookings') }}" class="sidebar-menu-item">
                    <i class="fas fa-clock"></i>
                    <span>Lịch Đặt</span>
                </a>
                <a href="{{ route('trainer.members.index') }}" class="sidebar-menu-item">
                    <i class="fas fa-users"></i>
                    <span>Hội Viên</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                    @csrf
                    <button type="submit" class="btn-upgrade" style="width: 100%;">
                        <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <!-- TOP HEADER -->
            <header class="top-header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Tìm kiếm...">
                </div>

                <div class="header-actions">
                    <i class="fas fa-bell notification-icon"></i>
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <div class="page-content">
                <!-- PAGE HEADER -->
                <div class="page-header">
                    <h1 class="page-title">Lịch Làm Việc</h1>
                    <p class="page-subtitle">Quản lý lịch làm việc của bạn</p>
                </div>

                @if($schedules->isEmpty())
                    <div style="text-align: center; padding: 3rem 1rem; background: white; border-radius: 1rem; border: 1px solid var(--border-color);">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem;"></i>
                        <p style="color: var(--text-secondary); font-size: 1rem;">Không có lịch làm việc trong tương lai</p>
                    </div>
                @else
                    <div class="members-card">
                        <table class="members-table">
                            <thead>
                                <tr>
                                    <th>📅 Ngày</th>
                                    <th>⏰ Bắt Đầu</th>
                                    <th>⏰ Kết Thúc</th>
                                    <th>⏱️ Thời Lượng</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $schedule)
                                    <tr>
                                        <td>
                                            <strong>{{ $schedule->work_date->format('d/m/Y') }}</strong>
                                            <br>
                                            <small style="color: var(--text-secondary);">{{ $schedule->work_date->isoFormat('dddd') }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $schedule->start_time }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $schedule->end_time }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                $start = strtotime($schedule->start_time);
                                                $end = strtotime($schedule->end_time);
                                                $hours = round(($end - $start) / 3600, 1);
                                            @endphp
                                            <span class="badge" style="background: rgba(22, 98, 255, 0.15); color: var(--primary-color); padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-weight: 600;">{{ $hours }}h</span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: var(--success-color); padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-weight: 600;">✓ Active</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- PAGINATION -->
                        <div class="pagination">
                            {{ $schedules->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>

</html>
