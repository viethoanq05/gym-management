<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lịch Đặt - IRON CORE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/trainer-dashboard.css', 'resources/js/app.js'])
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
                <a href="{{ route('trainer.schedule.index') }}" class="sidebar-menu-item">
                    <i class="fas fa-calendar"></i>
                    <span>Lịch Làm Việc</span>
                </a>
                <a href="{{ route('trainer.schedule.bookings') }}" class="sidebar-menu-item active">
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
                    <h1 class="page-title">Lịch Đặt Của Khách Hàng</h1>
                    <p class="page-subtitle">Quản lý và phê duyệt lịch đặt từ hội viên</p>
                </div>

                @if(session('success'))
                    <div style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success-color); border-radius: 1rem; margin-bottom: 1rem; color: var(--success-color);">
                        <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; background: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger-color); border-radius: 1rem; margin-bottom: 1rem; color: var(--danger-color);">
                        <i class="fas fa-exclamation-circle" style="font-size: 1.25rem;"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if($bookings->isEmpty())
                    <div style="text-align: center; padding: 3rem 1rem; background: white; border-radius: 1rem; border: 1px solid var(--border-color);">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem;"></i>
                        <p style="color: var(--text-secondary); font-size: 1rem;">Không có lịch đặt trong tương lai</p>
                    </div>
                @else
                    <div class="members-card">
                        <table class="members-table">
                            <thead>
                                <tr>
                                    <th>📅 Ngày</th>
                                    <th>⏰ Thời gian</th>
                                    <th>👤 Hội viên</th>
                                    <th>📌 Trạng thái</th>
                                    <th>⚙️ Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <strong>{{ $booking->booking_date->format('d/m/Y') }}</strong>
                                            <br>
                                            <small style="color: var(--text-secondary);">{{ $booking->booking_date->isoFormat('dddd') }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $booking->start_time }}</strong> - {{ $booking->end_time }}
                                            <br>
                                            @php
                                                $start = strtotime($booking->start_time);
                                                $end = strtotime($booking->end_time);
                                                $hours = round(($end - $start) / 3600, 1);
                                            @endphp
                                            <small style="color: var(--text-secondary);">{{ $hours }}h</small>
                                        </td>
                                        <td>
                                            <div class="member-info">
                                                <div>
                                                    <div class="member-name">{{ $booking->member->user->name }}</div>
                                                    <small style="color: var(--text-secondary);">{{ $booking->member->user->phone ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($booking->status == 1)
                                                <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: var(--success-color); padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-weight: 600;">✓ Xác nhận</span>
                                            @elseif($booking->status == 0)
                                                <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: var(--danger-color); padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-weight: 600;">✗ Hủy</span>
                                            @else
                                                <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: var(--warning-color); padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-weight: 600;">⏳ Chờ</span>
                                            @endif
                                        </td>
                                        <td style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                            @if($booking->status == 2)
                                                <form action="{{ route('trainer.schedule.accept', $booking->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem; background: var(--success-color);">
                                                        <i class="fas fa-check"></i> Nhận
                                                    </button>
                                                </form>
                                                <form action="{{ route('trainer.schedule.cancel', $booking->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem; background: var(--danger-color);">
                                                        <i class="fas fa-times"></i> Hủy
                                                    </button>
                                                </form>
                                            @elseif($booking->status == 1)
                                                <form action="{{ route('trainer.schedule.cancel', $booking->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem; background: var(--warning-color);">
                                                        <i class="fas fa-times"></i> Hủy
                                                    </button>
                                                </form>
                                                <a href="{{ route('trainer.members.show', $booking->member_id) }}" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                            @else
                                                <span style="color: var(--text-secondary);">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- PAGINATION -->
                        <div class="pagination">
                            {{ $bookings->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>

</html>
