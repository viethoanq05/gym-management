<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - IRON CORE</title>
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
                <a href="{{ route('trainer.dashboard') }}" class="sidebar-menu-item active">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('trainer.schedule.index') }}" class="sidebar-menu-item">
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
                    <h1 class="page-title">Chào buổi sáng, {{ auth()->user()->name }}! 👋</h1>
                    <p class="page-subtitle">Dưới đây là tổng quan hiệu suất của bạn</p>
                </div>

                <!-- METRICS CARDS -->
                <div class="cards-grid">
                    <!-- Teaching Hours -->
                    <div class="metric-card">
                        <div class="metric-label">
                            <i class="fas fa-clock"></i> Số giờ dạy
                        </div>
                        <div class="metric-value">{{ number_format($totalTeachingHours, 1) }}</div>
                        <div class="metric-change">
                            <i class="fas fa-arrow-up"></i> Tổng cộng
                        </div>
                    </div>

                    <!-- Bonus Points -->
                    <div class="metric-card">
                        <div class="metric-label">
                            <i class="fas fa-plus-circle"></i> Điểm cộng
                        </div>
                        <div class="metric-value" style="color: var(--success-color);">+{{ $bonusPoints }}</div>
                        <div class="metric-change">
                            <i class="fas fa-star"></i> Thành tích
                        </div>
                    </div>

                    <!-- Penalty Points -->
                    <div class="metric-card">
                        <div class="metric-label">
                            <i class="fas fa-minus-circle"></i> Điểm trừ
                        </div>
                        <div class="metric-value" style="color: var(--danger-color);">-{{ $penaltyPoints }}</div>
                        <div class="metric-change negative">
                            <i class="fas fa-exclamation-circle"></i> Cần cải thiện
                        </div>
                    </div>
                </div>

                <!-- TOTAL POINTS & UPCOMING SCHEDULES -->
                <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <!-- Total Points Card -->
                    <div class="members-card">
                        <div class="card-header" style="border-bottom: 2px solid var(--primary-color);">
                            <h2 class="card-title">Tổng Điểm</h2>
                        </div>
                        <div style="text-align: center; padding: 2rem 1rem;">
                            <div style="font-size: 3.5rem; font-weight: 700; @if($totalPoints >= 0) color: var(--success-color); @else color: var(--danger-color); @endif margin-bottom: 0.5rem;">
                                @if($totalPoints >= 0) + @endif{{ $totalPoints }}
                            </div>
                            <p style="color: var(--text-secondary); font-size: 0.875rem;">
                                @if($totalPoints >= 0)
                                    <i class="fas fa-smile"></i> Hiệu suất tuyệt vời!
                                @else
                                    <i class="fas fa-frown"></i> Cần nỗ lực hơn
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Upcoming Schedules -->
                    <div class="members-card">
                        <div class="card-header" style="border-bottom: 2px solid var(--primary-color);">
                            <h2 class="card-title">Lịch dạy hôm nay</h2>
                        </div>
                        @if($upcomingSchedules->isEmpty())
                            <div style="text-align: center; padding: 2rem 1rem; color: var(--text-secondary);">
                                <i class="fas fa-calendar-times" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                                <p>Không có lịch dạy hôm nay</p>
                            </div>
                        @else
                            <div style="max-height: 400px; overflow-y: auto;">
                                @foreach($upcomingSchedules->take(5) as $schedule)
                                    <div style="padding: 1rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <div style="font-weight: 600; color: var(--text-primary);">
                                                {{ $schedule->member->user->name ?? 'N/A' }}
                                            </div>
                                            <div style="font-size: 0.875rem; color: var(--text-secondary);">
                                                <i class="fas fa-clock"></i> {{ $schedule->start_time ?? 'N/A' }} - {{ $schedule->end_time ?? 'N/A' }}
                                            </div>
                                        </div>
                                        <span class="member-badge badge-success">
                                            @if($schedule->status == 1)
                                                Xác nhận
                                            @else
                                                Chờ xác nhận
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- QUICK ACTIONS -->
                <div class="members-card">
                    <div class="card-header">
                        <h2 class="card-title">Liên kết nhanh</h2>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                        <a href="{{ route('trainer.schedule.bookings') }}" class="btn btn-primary" style="justify-content: center; padding: 1rem;">
                            <i class="fas fa-calendar-check"></i> Lịch Đặt
                        </a>
                        <a href="{{ route('trainer.members.index') }}" class="btn btn-primary" style="justify-content: center; padding: 1rem;">
                            <i class="fas fa-users"></i> Danh Sách HV
                        </a>
                        <a href="{{ route('trainer.schedule.index') }}" class="btn btn-primary" style="justify-content: center; padding: 1rem;">
                            <i class="fas fa-calendar"></i> Lịch Làm Việc
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Add animation on load
        document.querySelectorAll('.metric-card').forEach((card, index) => {
            card.style.animation = `fadeInUp 0.6s ease ${index * 0.1}s both`;
        });

        // Add keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>
