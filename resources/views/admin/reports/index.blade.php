@extends('layouts.admin')

@section('title', 'Báo cáo')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Báo cáo</h1>
            <p class="mt-2 text-sm text-slate-500">Xem thống kê doanh thu, HLV và giờ check-in theo khoảng thời gian.</p>
        </div>

        <div class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:grid-cols-[minmax(0,1fr)_auto] items-end">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto] w-full">
                <label class="block">
                    <span class="text-sm text-slate-500">Từ ngày</span>
                    <input type="date" name="start_date" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                </label>

                <label class="block">
                    <span class="text-sm text-slate-500">Đến ngày</span>
                    <input type="date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                </label>

                <button type="submit" class="mt-6 inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">Lọc dữ liệu</button>
            </form>

            <a href="{{ route('admin.reports.export', request()->only(['start_date','end_date'])) }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">Xuất Excel</a>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[360px_minmax(0,1fr)]">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Top HLV được book</h2>
                    <p class="text-sm text-slate-500">Xếp hạng theo tổng lượt booking trong khoảng đã chọn.</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($topTrainers as $trainer)
                <div class="flex items-center justify-between rounded-2xl border border-slate-200 p-4">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-lg font-semibold text-slate-700">
                            {{ strtoupper(substr($trainer->trainer_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">{{ $trainer->trainer_name }}</p>
                            <p class="text-sm text-slate-500">HLV ID #{{ $trainer->trainer_id }}</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-semibold text-indigo-700">{{ $trainer->bookings_count }} lượt</span>
                </div>
                @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center text-slate-500">
                    Chưa có dữ liệu HLV trong khoảng thời gian này.
                </div>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Doanh thu theo gói tập</h2>
                        <p class="text-sm text-slate-500">Phân bổ doanh thu theo từng loại gói.</p>
                    </div>
                </div>

                <div class="h-[320px] rounded-3xl bg-slate-50 p-4">
                    <div id="packageRevenueChart" class="h-full w-full"></div>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Check-in theo khung giờ</h2>
                        <p class="text-sm text-slate-500">Thống kê số lượng check-in theo giờ.</p>
                    </div>
                </div>

                <div class="h-[320px] rounded-3xl bg-slate-50 p-4">
                    <div id="checkinHourChart" class="h-full w-full"></div>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Khung giờ cao điểm</h2>
                        <p class="text-sm text-slate-500">Số lần check-in theo giờ.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                        <thead>
                            <tr class="bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-500">
                                <th class="px-4 py-3">Giờ</th>
                                <th class="px-4 py-3">Lượt check-in</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($peakHours as $slot)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-4">{{ str_pad($slot->hour, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($slot->hour, 2, '0', STR_PAD_LEFT) }}:59</td>
                                <td class="px-4 py-4 font-semibold text-slate-900">{{ $slot->checkin_count }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-4 py-10 text-center text-slate-500">Không có dữ liệu check-in trong ngày đã chọn.</td>
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
// 1. Chuẩn bị sẵn dữ liệu mảng từ PHP
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
        // 3. Đọc dữ liệu từ HTML vào Javascript bằng JSON.parse
        const store = document.getElementById('reportDataStore');

        const revenueLabels = JSON.parse(store.dataset.revLabels || '[]');
        const revenueData = JSON.parse(store.dataset.revData || '[]');
        const checkinLabels = JSON.parse(store.dataset.chkLabels || '[]');
        const checkinData = JSON.parse(store.dataset.chkData || '[]');

        // Khởi tạo biểu đồ Doanh Thu
        const revenueChart = new ApexCharts(document.querySelector('#packageRevenueChart'), {
            chart: {
                type: 'donut',
                height: '100%'
            },
            series: revenueData,
            labels: revenueLabels,
            colors: ['#6366F1', '#EC4899', '#22C55E', '#F59E0B', '#14B8A6'],
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
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

        // Khởi tạo biểu đồ Check-in
        const checkinChart = new ApexCharts(document.querySelector('#checkinHourChart'), {
            chart: {
                type: 'bar',
                height: '100%'
            },
            series: [{
                name: 'Check-in',
                data: checkinData
            }],
            colors: ['#2563EB'],
            plotOptions: {
                bar: {
                    borderRadius: 12,
                    horizontal: false,
                    columnWidth: '55%'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: checkinLabels,
                labels: {
                    style: {
                        colors: '#64748B',
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: '',
                    style: {
                        color: '#475569',
                        fontSize: '12px'
                    }
                }
            },
            tooltip: {
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