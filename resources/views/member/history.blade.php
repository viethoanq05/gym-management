@extends('member.layout')

@section('title', 'Lịch sử gói tập')
@section('header_title', 'Lịch sử đăng ký')

@section('content')

<!-- Header Banner -->
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Lịch sử đăng ký gói tập</h1>
</div>

<!-- History Table Card -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 font-extrabold text-xs uppercase tracking-wider">
                    <th class="px-6 py-4">Gói tập</th>
                    <th class="px-6 py-4">Giá tiền</th>
                    <th class="px-6 py-4">Thời gian hiệu lực</th>
                    <th class="px-6 py-4">Trạng thái</th>
                    <th class="px-6 py-4 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm font-semibold text-slate-600">
                @forelse($memberships as $membership)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-extrabold text-slate-800">{{ $membership->package->name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase mt-1">Mã đăng ký: #{{ $membership->id }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-800">
                            {{ number_format($membership->package_price, 0, ',', '.') }} VNĐ
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-700">
                                {{ $membership->start_date->format('d/m/Y') }} — {{ $membership->end_date->format('d/m/Y') }}
                            </div>
                            <div class="text-[10px] text-slate-400 font-medium mt-0.5">
                                Thời hạn: {{ $membership->package->duration_days }} ngày
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($membership->status == \App\Models\Membership::ACTIVE)
                                <span class="bg-green-50 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full uppercase">
                                    Đang hoạt động
                                </span>
                            @elseif($membership->status == \App\Models\Membership::WAITING_PAYMENT)
                                <span class="bg-orange-50 text-orange-700 text-xs font-bold px-2.5 py-1 rounded-full uppercase animate-pulse">
                                    Chờ thanh toán
                                </span>
                            @elseif($membership->status == \App\Models\Membership::CANCELLED)
                                <span class="bg-slate-50 text-slate-400 text-xs font-bold px-2.5 py-1 rounded-full uppercase">
                                    Đã hủy
                                </span>
                            @else
                                <span class="bg-red-50 text-red-600 text-xs font-bold px-2.5 py-1 rounded-full uppercase">
                                    Đã hết hạn
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($membership->status == \App\Models\Membership::WAITING_PAYMENT || $membership->status == \App\Models\Membership::ACTIVE)
                                <form action="{{ route('member.memberships.cancel', $membership->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy?');" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold hover:underline transition">
                                        Hủy gói
                                    </button>
                                </form>
                            @else
                                <span class="text-slate-300 font-medium">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">
                            <div class="text-slate-300 mb-3">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12 mx-auto">
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                    <line x1="2" y1="10" x2="22" y2="10" />
                                </svg>
                            </div>
                            <h4>Chưa đăng ký gói tập nào</h4>
                            <p class="text-xs text-slate-400 mt-1 max-w-[250px] mx-auto leading-relaxed">Bạn có thể chọn và đăng ký gói tập để bắt đầu tham gia tập luyện.</p>
                            <a href="{{ route('member.packages') }}" class="mt-4 inline-flex bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs px-4 py-2 rounded-xl transition shadow-md shadow-blue-500/10">
                                Xem gói tập
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
