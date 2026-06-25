@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Widgets -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        $trendBookingsClass = \Illuminate\Support\Str::startsWith(($trendBookings ?? ''), '-') ? 'red-600' : 'green-600';
        @endphp
        {{-- No need for defaults, controller provides them --}}

        @if(auth()->user()->role === 'admin')
        <div class="rounded-2xl bg-white p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Tổng doanh thu</p>
                <div class="h-10 w-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 1v22" />
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-bold truncate">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }} đ</div>
                <div class="text-sm text-slate-400 mt-1">Trong tháng</div>
                <div class="mt-2 text-sm text-green-600">↑ {{ $trendRevenue }} so với tháng trước</div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Hội viên active</p>
                <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-bold truncate">{{ $totalMembers ?? 0 }}</div>
                <div class="text-sm text-slate-400 mt-1">Tổng hiện tại</div>
                <div class="mt-2 text-sm text-green-600">↑ {{ $trendMembers }} so với tháng trước</div>
            </div>
        </div>
        @endif

        <div class="rounded-2xl bg-white p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Check-in hôm nay</p>
                <div class="h-10 w-10 rounded-lg bg-cyan-100 text-cyan-700 flex items-center justify-center">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M9 12l2 2 4-4" />
                        <path d="M12 2a10 10 0 1010 10A10 10 0 0012 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-bold truncate">{{ $totalCheckIns ?? 0 }}</div>
                <div class="text-sm text-slate-400 mt-1">Hôm nay</div>
                <div class="mt-2 text-sm text-green-600">Cập nhật mới nhất</div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Booking hôm nay</p>
                <div class="h-10 w-10 rounded-lg bg-yellow-100 text-yellow-700 flex items-center justify-center">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M8 7h8M8 11h8M8 15h8" />
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-bold truncate">{{ $bookingsToday ?? 0 }}</div>
                <div class="text-sm text-slate-400 mt-1">Hôm nay</div>
                <div class="{{ 'mt-2 text-sm text-' . $trendBookingsClass }}">{{ $trendBookings ?? '0%' }} so với hôm trước</div>
            </div>
        </div>
    </div>

    <!-- Chart + Recent Bookings -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @if(auth()->user()->role === 'admin')
        <div class="col-span-2 rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Doanh thu</h3>
                    <p class="text-sm text-slate-400">Cập nhật: {{ \Carbon\Carbon::today()->format('d/m/Y') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <label for="timeFilter" class="text-sm text-slate-500">Khoảng thời gian</label>
                    <select id="timeFilter" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <option value="7days" selected>7 ngày qua</option>
                        <option value="this_month">Tháng này</option>
                        <option value="this_quarter">Quý này</option>
                    </select>
                </div>
            </div>
            @php
            $hasChartData = !empty($chartLabels) && !empty($chartData);
            $chartEmptyDisplay = $hasChartData ? 'display:none;' : 'display:flex;';
            @endphp
            <div id="chartWrapper" class="mt-4 w-full relative">
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="revenueChart" class="w-full h-full" data-dates='@json($chartLabels)' data-values='@json($chartData)'></canvas>
                </div>
                @if(! $hasChartData)
                <div id="chartEmptyState" class="absolute inset-0 flex items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-slate-50 text-slate-500">
                    <div class="text-center">
                        <svg class="mx-auto h-16 w-16 text-slate-300 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M3 3v18h18" />
                            <path d="M18 5l-5 5-4-4-6 6" />
                        </svg>
                        <p>Hôm nay chưa có dữ liệu ghi nhận</p>
                    </div>
                </div>
                @endif
                <div id="chartLoadingOverlay" class="absolute inset-0 hidden items-center justify-center rounded-2xl bg-slate-50/80 backdrop-blur-sm">
                    <div class="space-y-2 text-center">
                        <div class="h-3.5 w-32 animate-pulse rounded-full bg-slate-300"></div>
                        <div class="h-3.5 w-24 animate-pulse rounded-full bg-slate-300"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition">
            <h3 class="text-lg font-semibold mb-3">5 Lịch đặt mới nhất</h3>
            <div class="mt-2">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-sm">
                        <thead>
                            <tr class="text-left text-xs text-slate-500">
                                <th class="pb-3">Mã</th>
                                <th class="pb-3">Người đặt</th>
                                <th class="pb-3">Ngày</th>
                                <th class="pb-3">Giờ</th>
                                <th class="pb-3">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentBookings) && $recentBookings->isNotEmpty())
                            @foreach($recentBookings as $b)
                            @php
                            $status = (int) ($b->status ?? 2);
                            $badge = match($status) {
                            1 => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Đã xác nhận'],
                            0 => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Đã hủy'],
                            default => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'label' => 'Chờ xử lý'],
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
                            <tr class="border-t hover:bg-slate-50">
                                <td class="py-3">#{{ $b->id }}</td>
                                <td class="py-3 flex items-center gap-3">
                                    <div class="h-8 w-8 flex-shrink-0 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center">{{ $initials }}</div>
                                    <div>{{ $name }}</div>
                                </td>
                                <td class="py-3">{{ $displayDate }}</td>
                                <td class="py-3">{{ $b->start_time ?? '—' }}</td>
                                <td class="py-3">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badge['bg'] }} {{ $badge['text'] }}">{{ $badge['label'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="py-8">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-12 w-12 text-slate-300 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-4-5h-4v4h4v-4z" />
                                        </svg>
                                        <p class="text-sm text-slate-500">Hiện tại chưa có lịch đặt nào mới</p>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
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
            return {
                labels,
                values
            };
        }

        function renderChart(labels, values) {
            const ctx = chartEl.getContext('2d');

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
                        tension: 0.3,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.15)',
                        fill: true,
                        pointRadius: 3,
                        pointBackgroundColor: '#2563eb',
                        pointBorderWidth: 0,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.y || 0;
                                    return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#64748b'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(148, 163, 184, 0.15)'
                            },
                            ticks: {
                                color: '#64748b',
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