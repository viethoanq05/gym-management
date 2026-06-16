@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Widgets -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- No need for defaults, controller provides them --}}

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
                <div class="mt-2 text-sm text-{{ \Illuminate\Support\Str::startsWith(($trendBookings ?? ''), '-') ? 'red-600' : 'green-600' }}">{{ $trendBookings ?? '0%' }} so với hôm trước</div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">PT đang rảnh</p>
                <div class="h-10 w-10 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 2l3 7H9l3-7zM5 20h14v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-bold truncate">{{ $availableTrainers ?? 0 }}</div>
                <div class="text-sm text-slate-400 mt-1">Sẵn sàng</div>
                <div class="mt-2 text-sm text-green-600">{{ $trendPT ?? '+0%' }} so với tuần trước</div>
            </div>
        </div>
    </div>

    <!-- Chart + Recent Bookings -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="col-span-2 rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Doanh thu (7 ngày)</h3>
                <p class="text-sm text-slate-400">Đơn vị: VNĐ</p>
            </div>
            <div class="mt-4 h-64 w-full">
                @php
                $hasChartData = !empty($chartLabels) && !empty($chartData) && count($chartLabels) > 0;
                @endphp
                @if($hasChartData)
                <div id="revenueChart" class="w-full h-full"></div>
                @else
                <div class="w-full h-full flex flex-col items-center justify-center">
                    <svg class="h-16 w-16 text-slate-300 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M3 3v18h18" />
                        <path d="M18 5l-5 5-4-4-6 6" />
                    </svg>
                    <p class="text-slate-500">Chưa có dữ liệu giao dịch trong 7 ngày qua</p>
                </div>
                @endif
            </div>
        </div>

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
                            $status = strtolower($b->status ?? 'pending');
                            $badge = match($status) {
                            'confirmed' => ['bg' => 'bg-green-100','text' => 'text-green-700','label' => 'Đã xác nhận'],
                            'completed' => ['bg' => 'bg-blue-100','text' => 'text-blue-700','label' => 'Hoàn thành'],
                            default => ['bg' => 'bg-yellow-100','text' => 'text-yellow-700','label' => 'Chờ xử lý'],
                            };
                            $name = $b->user_name ?? 'Khách';
                            $initials = trim(collect(explode(' ', $name))->map(fn($p)=>substr($p,0,1))->join('')) ?: 'U';
                            @endphp
                            <tr class="border-t hover:bg-slate-50">
                                <td class="py-3">#{{ $b->id }}</td>
                                <td class="py-3 flex items-center gap-3">
                                    <div class="h-8 w-8 flex-shrink-0 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center">{{ $initials }}</div>
                                    <div>{{ $name }}</div>
                                </td>
                                <td class="py-3">{{ $b->booking_date ?? \Carbon\Carbon::parse($b->created_at)->format('d/m/Y') }}</td>
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

<div id="dashboard-chart-data" data-labels='@json($chartLabels ?? [])' data-values='@json($chartData ?? [])' style="display:none"></div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('dashboard-chart-data');
        let labels = JSON.parse(el?.dataset.labels || '[]');
        let values = JSON.parse(el?.dataset.values || '[]');
        const chartEl = document.querySelector('#revenueChart');

        // Only render if there's actual data
        if (!chartEl || !labels.length || !values.length) return;
        if (!values.some(v => v > 0)) return;

        const options = {
            series: [{
                name: 'Doanh thu',
                data: values
            }],
            chart: {
                type: 'area',
                height: '100%',
                toolbar: {
                    show: false
                },
                sparkline: {
                    enabled: false
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.6,
                    opacityTo: 0.05
                }
            },
            colors: ['#2563eb'],
            xaxis: {
                categories: labels,
                labels: {
                    style: {
                        colors: '#94a3b8'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return new Intl.NumberFormat('vi-VN').format(val);
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return new Intl.NumberFormat('vi-VN').format(val) + ' đ';
                    }
                }
            },
        };

        if (chartEl) {
            const chart = new ApexCharts(chartEl, options);
            chart.render();
        }
    });
</script>
@endpush

@endsection