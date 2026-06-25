@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="animate-fade-in-up">
        <h2 class="text-2xl font-bold text-white">Tổng quan</h2>
        <p class="text-sm text-slate-500 mt-1">Chào mừng trở lại! Đây là tóm tắt hoạt động hôm nay.</p>
    </div>

    <!-- Stat Widgets -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        $trendBookingsClass = \Illuminate\Support\Str::startsWith(($trendBookings ?? ''), '-') ? 'text-red-400' : 'text-emerald-400';
        @endphp

        @if(auth()->user()->role === 'admin')
        <!-- Revenue Card -->
        <div class="glass-card p-5 stat-card animate-fade-in-up stagger-1">
            <div class="flex items-center justify-between mb-4">
                <div class="h-11 w-11 rounded-xl gradient-success flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20">↑ {{ $trendRevenue }}</span>
            </div>
            <div data-kpi="revenue" class="text-2xl font-bold text-white tracking-tight">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }} đ</div>
            <p class="text-xs text-slate-500 mt-1.5">Tổng doanh thu trong tháng</p>
        </div>

        <!-- Members Card -->
        <div class="glass-card p-5 stat-card animate-fade-in-up stagger-2">
            <div class="flex items-center justify-between mb-4">
                <div class="h-11 w-11 rounded-xl gradient-primary flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-indigo-400 bg-indigo-500/10 px-2.5 py-1 rounded-full border border-indigo-500/20">↑ {{ $trendMembers }}</span>
            </div>
            <div data-kpi="members" class="text-2xl font-bold text-white tracking-tight">{{ $totalMembers ?? 0 }}</div>
            <p class="text-xs text-slate-500 mt-1.5">Hội viên đang hoạt động</p>
        </div>
        @endif

        <!-- Check-in Card -->
        <div class="glass-card p-5 stat-card animate-fade-in-up stagger-3">
            <div class="flex items-center justify-between mb-4">
                <div class="h-11 w-11 rounded-xl gradient-info flex items-center justify-center shadow-lg shadow-cyan-500/20">
                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-cyan-400 bg-cyan-500/10 px-2.5 py-1 rounded-full border border-cyan-500/20">Live</span>
            </div>
            <div class="text-2xl font-bold text-white tracking-tight">{{ $totalCheckIns ?? 0 }}</div>
            <p class="text-xs text-slate-500 mt-1.5">Check-in hôm nay</p>
        </div>

        <!-- Bookings Card -->
        <div class="glass-card p-5 stat-card animate-fade-in-up stagger-4">
            <div class="flex items-center justify-between mb-4">
                <div class="h-11 w-11 rounded-xl gradient-warning flex items-center justify-center shadow-lg shadow-amber-500/20">
                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <span class="text-xs font-medium {{ $trendBookingsClass }} bg-white/5 px-2.5 py-1 rounded-full border border-white/10">{{ $trendBookings ?? '0%' }}</span>
            </div>
            <div class="text-2xl font-bold text-white tracking-tight">{{ $bookingsToday ?? 0 }}</div>
            <p class="text-xs text-slate-500 mt-1.5">Booking hôm nay</p>
        </div>
    </div>

    <!-- Chart + Recent Bookings -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @if(auth()->user()->role === 'admin')
        <div class="col-span-2 glass-card p-6 animate-fade-in-up" style="animation-delay: 0.25s;">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
                <div>
                    <h3 class="text-base font-semibold text-white">Biểu đồ doanh thu</h3>
                    <p class="text-xs text-slate-500 mt-1">Cập nhật: {{ \Carbon\Carbon::today()->format('d/m/Y') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <select id="timeFilter" class="admin-input admin-select text-xs !py-2 !px-3 !rounded-lg w-auto">
                        <option value="7days" selected>7 ngày qua</option>
                        <option value="this_month">Tháng này</option>
                        <option value="this_quarter">Quý này</option>
                    </select>
                </div>
            </div>
            @php
            $hasChartData = !empty($chartLabels) && !empty($chartData);
            @endphp
            <div id="chartWrapper" class="w-full relative">
                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="revenueChart" class="w-full h-full" data-dates='@json($chartLabels)' data-values='@json($chartData)'></canvas>
                </div>
                @if(! $hasChartData)
                <div id="chartEmptyState" class="absolute inset-0 flex items-center justify-center rounded-2xl border border-dashed border-white/10 bg-white/[0.02]">
                    <div class="text-center">
                        <svg class="mx-auto h-14 w-14 text-slate-600 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M3 3v18h18" /><path d="M18 5l-5 5-4-4-6 6" />
                        </svg>
                        <p class="text-sm text-slate-500">Hôm nay chưa có dữ liệu ghi nhận</p>
                    </div>
                </div>
                @endif
                <div id="chartLoadingOverlay" class="absolute inset-0 hidden items-center justify-center rounded-2xl bg-slate-950/60 backdrop-blur-sm">
                    <div class="space-y-2 text-center">
                        <div class="h-3 w-32 animate-pulse rounded-full bg-slate-700"></div>
                        <div class="h-3 w-24 animate-pulse rounded-full bg-slate-700"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Bookings -->
        <div class="glass-card p-6 animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-semibold text-white">Lịch đặt mới nhất</h3>
                <span class="badge badge-primary">Top 5</span>
            </div>
            <div class="space-y-3">
                @if(isset($recentBookings) && $recentBookings->isNotEmpty())
                @foreach($recentBookings as $b)
                @php
                $status = (int) ($b->status ?? 2);
                $badgeClass = match($status) {
                    1 => 'badge-info',
                    0 => 'badge-danger',
                    default => 'badge-warning',
                };
                $badgeLabel = match($status) {
                    1 => 'Đã xác nhận',
                    0 => 'Đã hủy',
                    default => 'Chờ xử lý',
                };

                // Use nullsafe operator to avoid trying to read properties on null
                $name = $b->member?->user?->name ?? $b->user_name ?? 'Khách Vãng Lai';

                // Safe booking date formatting
                if (!empty($b->booking_date)) {
                    $displayDate = \Carbon\Carbon::parse($b->booking_date)->format('d/m/Y');
                } elseif (!empty($b->created_at)) {
                    $displayDate = \Carbon\Carbon::parse($b->created_at)->format('d/m/Y');
                } else {
                    $displayDate = '-';
                }

                $initials = trim(collect(explode(' ', $name))->map(fn($p) => substr($p, 0, 1))->join('')) ?: 'U';
                @endphp
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/[0.03] hover:bg-white/[0.06] transition group">
                    <div class="h-9 w-9 flex-shrink-0 rounded-lg bg-gradient-to-br from-indigo-500/20 to-violet-500/20 border border-indigo-500/20 text-indigo-300 flex items-center justify-center text-xs font-semibold">
                        {{ $initials }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-200 truncate">{{ $name }}</p>
                        <p class="text-[0.7rem] text-slate-500">{{ $displayDate }} · {{ $b->start_time ?? '—' }}</p>
                    </div>
                    <span class="badge {{ $badgeClass }} text-[0.65rem]">{{ $badgeLabel }}</span>
                </div>
                @endforeach
                @else
                <div class="empty-state py-10">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <p>Hiện tại chưa có lịch đặt nào mới</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartEl = document.getElementById('revenueChart');
        const filterEl = document.getElementById('timeFilter');
        const loadingOverlay = document.getElementById('chartLoadingOverlay');
        const emptyState = document.getElementById('chartEmptyState');
        let revenueChart = null;

        function parseChartData() {
            const labels = JSON.parse(chartEl.dataset.dates || '[]');
            const values = JSON.parse(chartEl.dataset.values || '[]');
            return { labels, values };
        }

        function renderChart(labels, values) {
            const ctx = chartEl.getContext('2d');

            // Create gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 320);
            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
            gradient.addColorStop(0.5, 'rgba(99, 102, 241, 0.08)');
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

            if (revenueChart) {
                revenueChart.data.labels = labels;
                revenueChart.data.datasets[0].data = values;
                revenueChart.update();
                return;
            }

            revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Doanh thu',
                        data: values,
                        tension: 0.4,
                        borderColor: '#818cf8',
                        backgroundColor: gradient,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#818cf8',
                        pointHoverBorderColor: '#0f172a',
                        pointHoverBorderWidth: 3,
                        borderWidth: 2.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        tooltip: {
                            backgroundColor: 'rgba(30, 41, 59, 0.95)',
                            titleColor: '#e2e8f0',
                            bodyColor: '#94a3b8',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            cornerRadius: 10,
                            padding: 12,
                            titleFont: { family: 'Inter', size: 13, weight: '600' },
                            bodyFont: { family: 'Inter', size: 12 },
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.y || 0;
                                    return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                                }
                            }
                        },
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: {
                                color: '#475569',
                                font: { family: 'Inter', size: 11 }
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.04)',
                                drawBorder: false,
                            },
                            border: { display: false },
                            ticks: {
                                color: '#475569',
                                font: { family: 'Inter', size: 11 },
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN').format(value);
                                }
                            }
                        }
                    }
                }
            });
        }

        function setLoading(isLoading) {
            if (!loadingOverlay) return;
            loadingOverlay.style.display = isLoading ? 'flex' : 'none';
            chartEl.style.opacity = isLoading ? '0.4' : '1';
        }

        function updateKpis(data) {
            const revenueEl = document.querySelector('[data-kpi="revenue"]');
            const membersEl = document.querySelector('[data-kpi="members"]');
            const revenueTrendEl = document.querySelector('[data-kpi="revenue-trend"]');
            const membersTrendEl = document.querySelector('[data-kpi="members-trend"]');

            if (revenueEl) revenueEl.textContent = new Intl.NumberFormat('vi-VN').format(data.totalRevenue) + ' đ';
            if (membersEl) membersEl.textContent = data.totalMembers;
            if (revenueTrendEl) revenueTrendEl.textContent = '↑ ' + data.trendRevenue + ' so với tháng trước';
            if (membersTrendEl) membersTrendEl.textContent = '↑ ' + data.trendMembers + ' so với tháng trước';
        }

        function updateChartState(labels, values) {
            const hasData = labels.length > 0;

            if (emptyState) {
                emptyState.style.display = hasData ? 'none' : 'flex';
            }

            if (!hasData) {
                return;
            }

            renderChart(labels, values);
        }

        async function fetchDataAndUpdateChart(filter = '7days') {
            if (!filterEl) {
                return;
            }

            setLoading(true);

            try {
                const response = await fetch("{{ route('admin.dashboard.data') }}?filter=" + encodeURIComponent(filter), {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Request failed');
                }

                const payload = await response.json();
                const data = payload.data;

                if (!data) {
                    throw new Error('Invalid response');
                }

                if (data.chartLabels && data.chartData && chartEl) {
                    chartEl.dataset.dates = JSON.stringify(data.chartLabels);
                    chartEl.dataset.values = JSON.stringify(data.chartData);
                    updateChartState(data.chartLabels, data.chartData);
                }

                updateKpis(data);
            } catch (error) {
                console.error(error);
            } finally {
                setLoading(false);
            }
        }

        if (chartEl) {
            const initial = parseChartData();
            updateChartState(initial.labels, initial.values);
        }

        if (filterEl) {
            filterEl.addEventListener('change', async function() {
                await fetchDataAndUpdateChart(this.value);
            });
        }

        fetchDataAndUpdateChart(filterEl ? filterEl.value : '7days');
    });
</script>
@endpush

@endsection