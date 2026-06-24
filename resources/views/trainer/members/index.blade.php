<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý Hội viên - IRON CORE</title>
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
        <main class="main-content">
            <!-- TOP HEADER -->
            <header class="top-header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="memberSearch" placeholder="Tìm kiếm hội viên...">
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
                    <h1 class="page-title">Hội viên đang phụ trách</h1>
                    <p class="page-subtitle">Quản lý và theo dõi thông tin sức khỏe của hội viên</p>
                </div>

                <!-- MEMBERS CARD -->
                <div class="members-card">
                    <div class="card-header">
                        <h2 class="card-title">Danh sách hội viên</h2>
                        <span class="view-all-btn">{{ $members->total() }} hội viên</span>
                    </div>

                    @if ($members->count() > 0)
                        <table class="members-table">
                            <thead>
                                <tr>
                                    <th>Hội Viên</th>
                                    <th>Giới Tính</th>
                                    <th>Ngày Sinh</th>
                                    <th>Chiều Cao (cm)</th>
                                    <th>Cân Nặng (kg)</th>
                                    <th>Ngày Tham Gia</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>
                                            <div class="member-info">
                                                <div class="member-avatar">
                                                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="member-name">{{ $member->user->name }}</div>
                                                    <small style="color: var(--text-secondary);">{{ $member->user->phone }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="member-badge {{ $member->gender === 'male' ? 'male' : 'female' }}">
                                                {{ $member->gender === 'male' ? '♂ Nam' : '♀ Nữ' }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            <strong>{{ $member->height ?? '-' }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $member->weight ?? '-' }}</strong>
                                        </td>
                                        <td>
                                            {{ $member->join_date ? \Carbon\Carbon::parse($member->join_date)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('trainer.members.show', $member->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> Xem Chi Tiết
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- PAGINATION -->
                        <div class="pagination">
                            {{ $members->links() }}
                        </div>
                    @else
                        <div style="text-align: center; padding: 3rem 1rem;">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem;"></i>
                            <p style="color: var(--text-secondary); font-size: 1rem;">Chưa có hội viên nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        // Search functionality
        const memberSearch = document.getElementById('memberSearch');
        if (memberSearch) {
            memberSearch.addEventListener('keyup', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('.members-table tbody tr');

                rows.forEach(row => {
                    const memberName = row.querySelector('.member-name').textContent.toLowerCase();
                    if (memberName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    </script>
</body>

</html>
