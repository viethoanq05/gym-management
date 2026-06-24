<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết hội viên - IRON CORE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/js/app.js'])
    <style>
        .member-header {
            background: linear-gradient(135deg, #1662ff 0%, #0f4ed1 100%);
            color: white;
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(22, 98, 255, 0.15);
        }

        .member-info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
        }

        .member-basic {
            flex: 1;
        }

        .member-basic h2 {
            margin: 0 0 0.5rem 0;
            font-size: 1.75rem;
            font-weight: 800;
        }

        .member-basic p {
            margin: 0.25rem 0;
            opacity: 0.95;
            font-size: 0.95rem;
        }

        .member-quick-stats {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .quick-stat {
            background: rgba(255, 255, 255, 0.15);
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .quick-stat small {
            display: block;
            opacity: 0.85;
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
        }

        .quick-stat strong {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .metric-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1662ff, #0f4ed1);
        }

        .metric-card.success::before {
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .metric-card.warning::before {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }

        .metric-card.danger::before {
            background: linear-gradient(90deg, #ef4444, #dc2626);
        }

        .metric-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: inline-block;
        }

        .metric-label {
            color: #667085;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .metric-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #101828;
            line-height: 1;
        }

        .metric-subtext {
            color: #667085;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
        }

        .stat-item strong {
            color: #101828;
            font-weight: 700;
        }

        .stat-item em {
            color: #667085;
            font-style: normal;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #101828;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: #1662ff;
        }

        .info-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            padding: 0.75rem 0;
        }

        .info-item label {
            color: #667085;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 0.5rem;
        }

        .info-item strong {
            color: #101828;
            font-size: 1.125rem;
            display: block;
        }

        .checkin-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #1662ff;
        }

        .checkin-card.inactive {
            border-left-color: #d1d5db;
            opacity: 0.7;
        }

        .checkin-time {
            font-size: 0.9rem;
            color: #667085;
            margin-bottom: 0.5rem;
        }

        .checkin-time strong {
            color: #101828;
            font-weight: 700;
            font-size: 1.125rem;
        }

        .checkin-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .checkin-status.active {
            color: #10b981;
        }

        .checkin-status.pending {
            color: #f59e0b;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .modern-table thead {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .modern-table th {
            padding: 1rem;
            text-align: left;
            color: #667085;
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modern-table td {
            padding: 1rem;
            color: #101828;
            border-bottom: 1px solid #e2e8f0;
        }

        .modern-table tbody tr:hover {
            background: #f9fafb;
        }

        .duration-badge {
            display: inline-block;
            background: #e0e9f8;
            color: #1662ff;
            padding: 0.35rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-badge.active {
            background: #d1fae5;
            color: #047857;
        }

        .status-badge.inactive {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
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
                <a href="{{ route('trainer.schedule.bookings') }}" class="sidebar-menu-item">
                    <i class="fas fa-clock"></i>
                    <span>Lịch Đặt</span>
                </a>
                <a href="{{ route('trainer.members.index') }}" class="sidebar-menu-item active">
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
        <div class="main-content">
            <!-- PAGE CONTENT -->
            <div class="page-content">
                <!-- Back Button -->
                <div style="margin-bottom: 1.5rem;">
                    <a href="{{ route('trainer.members.index') }}" style="color: #1662ff; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>

                <!-- Member Header Card -->
                <div class="member-header">
                    <div class="member-info-row">
                        <div class="member-basic">
                            <h2>{{ $member->user->name }}</h2>
                            <p>📧 {{ $member->user->email }}</p>
                            <p>📱 {{ $member->user->phone }}</p>
                            <div class="member-quick-stats" style="margin-top: 1rem;">
                                <div class="quick-stat">
                                    <small>Giới tính</small>
                                    <strong>@if($member->gender == 'male') Nam @else Nữ @endif</strong>
                                </div>
                                <div class="quick-stat">
                                    <small>Check-in tháng này</small>
                                    <strong>{{ $checkinsThisMonth }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Health Metrics Section -->
                <h3 class="section-title">
                    <i class="fas fa-heartbeat"></i> Chỉ số sức khỏe
                </h3>
                <div class="metrics-grid">
                    <!-- Height -->
                    <div class="metric-card">
                        <div class="metric-icon">📏</div>
                        <div class="metric-label">Chiều cao</div>
                        <div class="metric-value">{{ number_format($member->height, 1) }}</div>
                        <div class="metric-subtext">cm</div>
                    </div>

                    <!-- Weight -->
                    <div class="metric-card">
                        <div class="metric-icon">⚖️</div>
                        <div class="metric-label">Cân nặng</div>
                        <div class="metric-value">{{ number_format($member->weight, 1) }}</div>
                        <div class="metric-subtext">kg</div>
                    </div>

                    <!-- BMI -->
                    <div class="metric-card @if($bmi < 18.5) warning @elseif($bmi < 25) success @elseif($bmi < 30) warning @else danger @endif">
                        <div class="metric-icon">📊</div>
                        <div class="metric-label">Chỉ số BMI</div>
                        <div class="metric-value">{{ $bmi }}</div>
                        <div class="metric-subtext">
                            @if($bmi < 18.5)
                                Thiếu cân
                            @elseif($bmi < 25)
                                Bình thường
                            @elseif($bmi < 30)
                                Thừa cân
                            @else
                                Béo phì
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Check-in Activity Section -->
                <h3 class="section-title">
                    <i class="fas fa-check-circle"></i> Hoạt động gần đây
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                    @if($lastCheckIn)
                    <div class="checkin-card">
                        <div class="checkin-time">
                            Lần check-in gần nhất:<br>
                            <strong>{{ $lastCheckIn->checkin_time->format('d/m/Y H:i') }}</strong>
                        </div>
                        @if($lastCheckIn->checkout_time)
                            <div class="checkin-status active">
                                <i class="fas fa-check"></i> Check-out: {{ $lastCheckIn->checkout_time->format('H:i') }}
                            </div>
                        @else
                            <div class="checkin-status pending">
                                <i class="fas fa-hourglass-half"></i> Chưa check-out
                            </div>
                        @endif
                    </div>
                    @else
                    <div class="checkin-card inactive">
                        <div class="checkin-time" style="opacity: 0.7;">
                            Lần check-in gần nhất<br>
                            <strong style="opacity: 0.7;">Chưa có check-in</strong>
                        </div>
                    </div>
                    @endif

                    <div class="checkin-card">
                        <div class="checkin-time">
                            Thống kê tháng này:<br>
                            <strong>{{ $checkinsThisMonth }} lần check-in</strong>
                        </div>
                        <div style="color: #667085; font-size: 0.875rem; margin-top: 0.5rem;">
                            Tháng {{ now()->format('m/Y') }}
                        </div>
                    </div>
                </div>

                <!-- Check-in History Table -->
                @if(!$checkinHistory->isEmpty())
                <h3 class="section-title">
                    <i class="fas fa-history"></i> Lịch sử check-in
                </h3>
                <div style="margin-bottom: 2rem;">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>📅 Ngày tháng</th>
                                <th>⏰ Check-in</th>
                                <th>⏱️ Check-out</th>
                                <th>⏱️ Thời lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checkinHistory as $checkin)
                            <tr>
                                <td>{{ $checkin->checkin_time->format('d/m/Y (l)', ['l' => 'Monday']) }}</td>
                                <td>
                                    <strong>{{ $checkin->checkin_time->format('H:i') }}</strong>
                                </td>
                                <td>
                                    @if($checkin->checkout_time)
                                        <strong>{{ $checkin->checkout_time->format('H:i') }}</strong>
                                    @else
                                        <span class="status-badge inactive">
                                            <i class="fas fa-spinner"></i> Đang tập
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($checkin->checkout_time)
                                        @php
                                            $duration = $checkin->checkout_time->diffInMinutes($checkin->checkin_time);
                                            $hours = floor($duration / 60);
                                            $minutes = $duration % 60;
                                        @endphp
                                        <span class="duration-badge">{{ $hours }}h {{ $minutes }}m</span>
                                    @else
                                        <span style="color: #d1d5db;">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div style="display: flex; justify-content: center; margin-top: 2rem;">
                    {{ $checkinHistory->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
                                <p style="color: #101828; font-weight: 600;">{{ $member->user->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <p style="color: #667085; font-size: 0.9rem; margin-bottom: 0.25rem;">Email</p>
                                <p style="color: #101828; font-weight: 600;">{{ $member->user->email }}</p>
                            </div>
                            <div class="col-md-3">
                                <p style="color: #667085; font-size: 0.9rem; margin-bottom: 0.25rem;">Điện thoại</p>
                                <p style="color: #101828; font-weight: 600;">{{ $member->user->phone }}</p>
                            </div>
                            <div class="col-md-3">
                                <p style="color: #667085; font-size: 0.9rem; margin-bottom: 0.25rem;">Giới tính</p>
                                <p style="margin: 0;">
                                    @if($member->gender == 'male')
                                        <span class="badge" style="background: #1662ff; color: white;">Nam</span>
                                    @else
                                        <span class="badge" style="background: #ef4444; color: white;">Nữ</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chỉ số sức khỏe -->
                <div class="row" style="margin-bottom: 1.5rem;">
                    <div class="col-md-4">
                        <div class="card" style="background: #1662ff; color: white; border: none;">
                            <div class="card-body">
                                <h6 style="margin: 0 0 0.5rem 0; opacity: 0.9;">📏 Chiều cao</h6>
                                <h3 style="margin: 0; font-weight: 800;">{{ number_format($member->height, 1) }} cm</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card" style="background: #f59e0b; color: white; border: none;">
                            <div class="card-body">
                                <h6 style="margin: 0 0 0.5rem 0; opacity: 0.9;">⚖️ Cân nặng</h6>
                                <h3 style="margin: 0; font-weight: 800;">{{ number_format($member->weight, 1) }} kg</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card" style="background: @if($bmi < 18.5) #10b981 @elseif($bmi < 25) #1662ff @elseif($bmi < 30) #f59e0b @else #ef4444 @endif; color: white; border: none;">
                            <div class="card-body">
                                <h6 style="margin: 0 0 0.5rem 0; opacity: 0.9;">📊 BMI</h6>
                                <h3 style="margin: 0; font-weight: 800;">{{ $bmi }}</h3>
                                <small style="opacity: 0.9;">
                                    @if($bmi < 18.5)
                                        Thiếu cân
                                    @elseif($bmi < 25)
                                        Bình thường
                                    @elseif($bmi < 30)
                                        Thừa cân
                                    @else
                                        Béo phì
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thống kê tham gia -->
                <div class="row" style="margin-bottom: 1.5rem;">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 style="margin: 0 0 1rem 0; color: #101828; font-weight: 700;">⏱️ Lần check-in gần nhất</h6>
                                @if($lastCheckIn)
                                    <p style="margin: 0.5rem 0; color: #101828; font-weight: 600;">
                                        {{ $lastCheckIn->checkin_time->format('d/m/Y H:i') }}
                                    </p>
                    @if($lastCheckIn->checkout_time)
                        <p style="color: #667085; font-size: 0.9rem; margin: 0;">Check-out: {{ $lastCheckIn->checkout_time->format('d/m/Y H:i') }}</p>
                    @else
                        <p style="color: #ef4444; font-size: 0.9rem; margin: 0;"><i class="fas fa-exclamation-circle"></i> Chưa check-out</p>
                    @endif
                @else
                    <p style="color: #667085; margin: 0;">Chưa có check-in nào</p>
                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 style="margin: 0 0 1rem 0; color: #101828; font-weight: 700;">📈 Thống kê tháng này</h6>
                                <p style="margin: 0; color: #101828; font-weight: 600;">
                                    <strong>{{ $checkinsThisMonth }}</strong> lần check-in
                                </p>
                                <small style="color: #667085;">Tháng {{ now()->format('m/Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lịch sử check-in -->
                <div class="card">
                    <div class="card-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 1rem;">
                        <h5 style="margin: 0; color: #101828; font-weight: 700; font-size: 1rem;">📋 Lịch sử check-in</h5>
                    </div>
                    <div class="card-body">
                        @if($checkinHistory->isEmpty())
                            <p style="color: #667085; margin: 0;">Không có lịch sử check-in</p>
                        @else
                            <div class="table-responsive">
                                <table class="members-table" style="width: 100%; margin: 0;">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%;">📅 Ngày</th>
                                            <th style="width: 20%;">⏰ Check-in</th>
                                            <th style="width: 20%;">⏰ Check-out</th>
                                            <th style="width: 20%;">⏱️ Thời lượng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($checkinHistory as $checkin)
                                            <tr>
                                                <td>{{ $checkin->checkin_time->format('d/m/Y') }}</td>
                                                <td>{{ $checkin->checkin_time->format('H:i') }}</td>
                                                <td>
                                                    @if($checkin->checkout_time)
                                                        {{ $checkin->checkout_time->format('H:i') }}
                                                    @else
                                                        <span style="background: #f59e0b; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; font-size: 0.85rem; font-weight: 600;">Đang tập</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($checkin->checkout_time)
                                                        @php
                                                            $duration = $checkin->checkout_time->diffInMinutes($checkin->checkin_time);
                                                            $hours = floor($duration / 60);
                                                            $minutes = $duration % 60;
                                                        @endphp
                                                        <span style="background: #e0e9f8; color: #1662ff; padding: 0.25rem 0.75rem; border-radius: 0.375rem; font-size: 0.85rem; font-weight: 600;">{{ $hours }}h {{ $minutes }}m</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pagination -->
                @if(!$checkinHistory->isEmpty())
                    <div style="margin-top: 2rem; display: flex; justify-content: center;">
                        {{ $checkinHistory->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
