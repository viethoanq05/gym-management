@extends('layouts.admin')

@section('title', 'Báo cáo')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <span class="text-slate-300">Báo cáo</span>
        </div>
        <h2 class="page-title">Báo cáo & Thống kê</h2>
        <p class="page-subtitle">Xem thống kê doanh thu, HLV và giờ check-in theo khoảng thời gian.</p>
    </div>

    {{-- Filter Bar --}}
    <div class="glass-card p-5 animate-fade-in-up">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end flex-1">
                <div class="flex-1 min-w-[160px]">
                    <label class="admin-label">Từ ngày</label>
                    <input type="date" name="start_date" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}" class="admin-input" />
                </div>
                <div class="flex-1 min-w-[160px]">
                    <label class="admin-label">Đến ngày</label>
                    <input type="date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}" class="admin-input" />
                </div>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    Lọc dữ liệu
                </button>
            </form>

            <a href="{{ route('admin.reports.export', request()->only(['start_date','end_date'])) }}" class="btn-secondary">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Xuất Excel
            </a>
        </div>
    </div>

    {{-- Main Grid: Top Trainers + Charts --}}
    <div class="grid gap-6 xl:grid-cols-[380px_minmax(0,1fr)]">

        {{-- Top Trainers --}}
        <div class="glass-card p-6 animate-fade-in-up stagger-1">
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-1">
                    <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600">
                        <svg class="w-4.5 h-4.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h2 class="text-lg font-semibold text-white">Top HLV được book</h2>
                </div>
                <p class="text-sm text-slate-500 ml-12">Xếp hạng theo tổng lượt booking trong khoảng đã chọn.</p>
            </div>

            <div class="space-y-3">
                @forelse($topTrainers as $index => $trainer)
                @php
                    $gradients = [
                        'from-amber-400 to-orange-500',
                        'from-slate-300 to-slate-400',
                        'from-amber-600 to-amber-700',
                        'from-indigo-400 to-violet-500',
                        'from-emerald-400 to-teal-500',
                    ];
                    $gradient = $gradients[$index] ?? 'from-slate-500 to-slate-600';
                @endphp
                <div class="flex items-center justify-between rounded-xl border border-white/5 bg-white/[0.03] p-4 transition hover:bg-white/[0.06] hover:border-white/10">
                    <div class="flex items-center gap-3.5">
                        {{-- Ranking number --}}
                        <div class="flex items-center justify-center w-7 h-7 rounded-lg text-xs font-bold {{ $index < 3 ? 'bg-gradient-to-br ' . $gradient . ' text-white shadow-lg' : 'bg-white/5 text-slate-500' }}">
                            {{ $index + 1 }}
                        </div>
                        {{-- Avatar --}}
                        <div class="flex items-center justify-center w-11 h-11 rounded-full bg-gradient-to-br {{ $gradient }} text-white text-base font-bold shadow-lg">
                            {{ strtoupper(substr($trainer->trainer_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-white text-sm">{{ $trainer->trainer_name }}</p>
                            <p class="text-xs text-slate-500">HLV ID #{{ $trainer->trainer_id }}</p>
                        </div>
                    </div>
                    <span class="badge badge-primary">{{ $trainer->bookings_count }} lượt</span>
                </div>
                @empty
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <p>Chưa có dữ liệu HLV trong khoảng thời gian này.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Right Column: Charts + Peak Hours Table --}}
        <div class="space-y-6">

            {{-- Revenue by Package (Donut) --}}
            <div class="glass-card p-6 animate-fade-in-up stagger-2">
                <div class="mb-5 flex items-center gap-3">
                    <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600">
                        <svg class="w-4.5 h-4.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-white">Doanh thu theo gói tập</h2>
                        <p class="text-sm text-slate-500">Phân bổ doanh thu theo từng loại gói.</p>
                    </div>
                </div>

                <div class="h-[340px] rounded-2xl bg-white/[0.02] border border-white/5 p-4">
                    <div id="packageRevenueChart" class="h-full w-full"></div>
                </div>
            </div>

            {{-- Check-in by Hour (Bar) --}}
            <div class="glass-card p-6 animate-fade-in-up stagger-3">
                <div class="mb-5 flex items-center gap-3">
                    <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600">
                        <svg class="w-4.5 h-4.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-white">Check-in theo khung giờ</h2>
                        <p class="text-sm text-slate-500">Thống kê số lượng check-in theo giờ.</p>
                    </div>
                </div>

                <div class="h-[340px] rounded-2xl bg-white/[0.02] border border-white/5 p-4">
                    <div id="checkinHourChart" class="h-full w-full"></div>
                </div>
            </div>

            {{-- Peak Hours Table --}}
            <div class="glass-card p-0 overflow-hidden animate-fade-in-up stagger-4">
                <div class="p-6 pb-0 mb-5 flex items-center gap-3">
                    <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600">
                        <svg class="w-4.5 h-4.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-white">Khung giờ cao điểm</h2>
                        <p class="text-sm text-slate-500">Số lần check-in theo giờ.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Giờ</th>
                                <th>Lượt check-in</th>
                                <th>Mức độ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peakHours as $slot)
                            @php
                                $maxCheckin = $peakHours->max('checkin_count') ?: 1;
                                $percentage = round(($slot->checkin_count / $maxCheckin) * 100);
                            @endphp
                            <tr>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span class="text-slate-200 font-medium">{{ str_pad($slot->hour, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($slot->hour, 2, '0', STR_PAD_LEFT) }}:59</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="font-semibold text-white">{{ $slot->checkin_count }}</span>
                                    <span class="text-slate-500 text-xs ml-1">lượt</span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3 min-w-[140px]">
                                        <div class="flex-1 h-2 rounded-full bg-white/5 overflow-hidden">
                                            <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-violet-500 transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-xs text-slate-500 w-10 text-right">{{ $percentage }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="!p-0">
                                    <div class="empty-state">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <p>Không có dữ liệu check-in trong khoảng thời gian đã chọn.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
@php
// Chuẩn bị dữ liệu mảng từ PHP
$revLabels = $revenueByPackage->pluck('package_name')->all();
$revData = $revenueByPackage->pluck('total_revenue')->all();

$chkLabels = $peakHours->map(function($slot) {
return sprintf('%02d:00', $slot->hour);
})->all();
$chkData = $peakHours->pluck('checkin_count')->all();
@endphp

<div id="reportDataStore" class="hidden"
    data-rev-labels='@json($revLabels)'
    data-rev-data='@json($revData)'
    data-chk-labels='@json($chkLabels)'
    data-chk-data='@json($chkData)'>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const store = document.getElementById('reportDataStore');

        const revenueLabels = JSON.parse(store.dataset.revLabels || '[]');
        const revenueData   = JSON.parse(store.dataset.revData   || '[]');
        const checkinLabels = JSON.parse(store.dataset.chkLabels || '[]');
        const checkinData   = JSON.parse(store.dataset.chkData   || '[]');

        const themeColors = ['#818cf8', '#c084fc', '#34d399', '#fbbf24', '#22d3ee'];

        // ── Donut: Doanh thu theo gói ──
        const revenueChart = new ApexCharts(document.querySelector('#packageRevenueChart'), {
            chart: {
                type: 'donut',
                height: '100%',
                background: 'transparent',
                foreColor: '#94a3b8'
            },
            theme: {
                mode: 'dark',
                palette: 'palette1'
            },
            series: revenueData,
            labels: revenueLabels,
            colors: themeColors,
            stroke: {
                show: true,
                width: 2,
                colors: ['rgba(15, 23, 42, 0.8)']
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '68%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '14px',
                                color: '#e2e8f0'
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 700,
                                color: '#f1f5f9',
                                formatter: function(val) {
                                    return new Intl.NumberFormat('vi-VN').format(val) + 'đ';
                                }
                            },
                            total: {
                                show: true,
                                label: 'Tổng doanh thu',
                                fontSize: '12px',
                                color: '#94a3b8',
                                formatter: function(w) {
                                    const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return new Intl.NumberFormat('vi-VN').format(total) + 'đ';
                                }
                            }
                        }
                    }
                }
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '13px',
                labels: {
                    colors: '#94a3b8'
                },
                markers: {
                    width: 10,
                    height: 10,
                    radius: 3
                }
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                theme: 'dark',
                style: {
                    fontSize: '13px'
                },
                y: {
                    formatter: function(value) {
                        return new Intl.NumberFormat('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(value);
                    }
                }
            }
        });
        revenueChart.render();

        // ── Bar: Check-in theo khung giờ ──
        const checkinChart = new ApexCharts(document.querySelector('#checkinHourChart'), {
            chart: {
                type: 'bar',
                height: '100%',
                background: 'transparent',
                foreColor: '#94a3b8',
                toolbar: {
                    show: false
                }
            },
            theme: {
                mode: 'dark',
                palette: 'palette1'
            },
            series: [{
                name: 'Check-in',
                data: checkinData
            }],
            colors: ['#818cf8'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'vertical',
                    gradientToColors: ['#c084fc'],
                    stops: [0, 100]
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: false,
                    columnWidth: '55%',
                    distributed: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: false
            },
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.04)',
                strokeDashArray: 4,
                xaxis: {
                    lines: { show: false }
                },
                yaxis: {
                    lines: { show: true }
                }
            },
            xaxis: {
                categories: checkinLabels,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px'
                    }
                }
            },
            tooltip: {
                theme: 'dark',
                style: {
                    fontSize: '13px'
                },
                y: {
                    formatter: function(value) {
                        return value + ' lượt';
                    }
                }
            }
        });
        checkinChart.render();
    });
</script>
@endpush