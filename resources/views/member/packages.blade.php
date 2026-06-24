@extends('member.layout')

@section('title', 'Đăng ký gói tập')
@section('header_title', 'Danh sách gói tập')

@section('content')

<!-- Header Banner -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-6">
    <h1 class="text-2xl xl:text-3xl font-extrabold text-slate-800 tracking-tight">Chọn gói tập của bạn</h1>
    <p class="text-slate-500 font-medium mt-1">Lựa chọn gói tập phù hợp nhất với mục tiêu tập luyện của bạn.</p>
</div>

<!-- Active Membership Alert -->
@if($activeMembership)
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 xl:p-6 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-start gap-4">
            <span class="bg-blue-600 text-white p-3 rounded-xl shrink-0">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg>
            </span>
            <div>
                <h3 class="text-base font-extrabold text-slate-800">Bạn đang sử dụng gói: <span class="text-blue-600">{{ $activeMembership->package->name }}</span></h3>
                <p class="text-slate-500 text-sm mt-1">
                    Ngày đăng ký: {{ $activeMembership->start_date->format('d/m/Y') }} — Có hiệu lực đến: <strong class="text-slate-700">{{ $activeMembership->end_date->format('d/m/Y') }}</strong>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1.5 rounded-full uppercase">
                Đang kích hoạt
            </span>
            
            <form action="{{ route('member.memberships.cancel', $activeMembership->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy gói tập hiện tại? Hành động này không thể hoàn tác.');">
                @csrf
                @method('PATCH')
                <button type="submit" class="text-red-600 hover:text-red-700 font-bold text-sm bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl transition">
                    Hủy gói
                </button>
            </form>
        </div>
    </div>
@endif

<!-- Pending Payment Alert -->
@php
    $pendingMembership = $memberships->where('status', \App\Models\Membership::WAITING_PAYMENT)->first();
@endphp
@if($pendingMembership)
    <div class="bg-orange-50 border border-orange-200 rounded-2xl p-4 xl:p-6 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-start gap-4">
            <span class="bg-orange-500 text-white p-3 rounded-xl shrink-0">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </span>
            <div>
                <h3 class="text-base font-extrabold text-slate-800">Yêu cầu đăng ký gói <span class="text-orange-600">{{ $pendingMembership->package->name }}</span> đang chờ duyệt</h3>
                <p class="text-slate-500 text-sm mt-1">
                    Vui lòng liên hệ quầy lễ tân để thanh toán số tiền: <strong class="text-slate-700">{{ number_format($pendingMembership->package_price, 0, ',', '.') }} VNĐ</strong> để kích hoạt gói.
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="bg-orange-100 text-orange-800 text-xs font-bold px-3 py-1.5 rounded-full uppercase">
                Chờ thanh toán
            </span>
            
            <form action="{{ route('member.memberships.cancel', $pendingMembership->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đăng ký này?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="text-slate-500 hover:text-slate-700 font-bold text-sm bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-xl transition">
                    Hủy yêu cầu
                </button>
            </form>
        </div>
    </div>
@endif

<!-- Packages List Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 xl:gap-6 mb-6 overflow-hidden" id="packages-grid">
    @foreach($packages as $index => $package)
        @php
            $isCurrent = $activeMembership && $activeMembership->package_id == $package->id;
            $isPending = $pendingMembership && $pendingMembership->package_id == $package->id;
            $durationDays = (int) $package->duration_days;
        @endphp
        
        <div class="package-card bg-white rounded-2xl xl:rounded-3xl border-2 {{ $isCurrent ? 'border-blue-600 ring-4 ring-blue-50' : 'border-slate-100' }} p-5 xl:p-8 shadow-sm flex flex-col relative overflow-hidden cursor-pointer group"
             data-package-index="{{ $index }}"
             onclick="selectPackage(this)"
             style="transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
            @if($isCurrent)
                <span class="absolute top-0 right-0 bg-blue-600 text-white font-extrabold text-[10px] uppercase tracking-wider px-4 py-1.5 rounded-bl-xl">
                    Đang sử dụng
                </span>
            @endif

            <h3 class="text-xl font-extrabold text-slate-800">{{ $package->name }}</h3>
            
            <!-- Price Display -->
            <div class="flex items-end gap-1 mt-4">
                <span class="text-3xl xl:text-4xl font-extrabold text-slate-900 leading-none">
                    {{ number_format($package->price, 0, ',', '.') }}
                </span>
                <span class="text-slate-400 font-semibold text-sm">VNĐ / {{ $durationDays }} ngày</span>
            </div>

            <!-- Description -->
            <p class="text-slate-500 text-sm mt-4 leading-relaxed flex-1">
                {{ $package->description ?: 'Gói tập luyện cơ bản tại phòng tập với đầy đủ trang thiết bị hiện đại.' }}
            </p>

            <!-- Features List -->
            <ul class="space-y-2.5 mt-4 xl:mt-6 mb-6 xl:mb-8 text-sm font-semibold text-slate-600">
                <li class="flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-green-500">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Tập luyện trong {{ $durationDays }} ngày</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-green-500">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Truy cập đầy đủ thiết bị</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-green-500">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Gửi xe miễn phí</span>
                </li>
            </ul>

            <!-- Subscribe Button -->
            <form action="{{ route('member.memberships.subscribe') }}" method="POST">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                
                @if($isCurrent)
                    <button type="button" disabled class="w-full bg-slate-100 text-slate-400 font-extrabold py-3 px-4 rounded-xl text-sm cursor-not-allowed">
                        Đang sử dụng gói này
                    </button>
                @elseif($isPending)
                    <button type="button" disabled class="w-full bg-slate-100 text-slate-400 font-extrabold py-3 px-4 rounded-xl text-sm cursor-not-allowed">
                        Đang chờ thanh toán
                    </button>
                @elseif($pendingMembership || $activeMembership)
                    <button type="submit" class="w-full bg-slate-100 text-slate-600 hover:bg-slate-200 font-extrabold py-3 px-4 rounded-xl text-sm transition">
                        Thay đổi gói tập
                    </button>
                @else
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3 px-4 rounded-xl text-sm transition shadow-md shadow-blue-500/10">
                        Đăng ký ngay
                    </button>
                @endif
            </form>
        </div>
    @endforeach
</div>

<style>
    .package-card {
        transform: translateY(0);
    }
    .package-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.12);
    }
    .package-card.selected {
        border-color: #1662ff !important;
        box-shadow: 0 0 0 3px rgba(22, 98, 255, 0.15), 0 8px 25px -8px rgba(0,0,0,0.1);
        transform: translateY(-4px);
    }
    .package-card.not-selected {
        opacity: 0.55;
        transform: translateY(2px);
    }
</style>

<script>
    function selectPackage(card) {
        const allCards = document.querySelectorAll('.package-card');
        const isAlreadySelected = card.classList.contains('selected');

        // Reset all cards
        allCards.forEach(c => {
            c.classList.remove('selected', 'not-selected');
        });

        // If clicking the same card, deselect (toggle off)
        if (isAlreadySelected) return;

        // Highlight selected, dim others
        allCards.forEach(c => {
            if (c === card) {
                c.classList.add('selected');
            } else {
                c.classList.add('not-selected');
            }
        });
    }
</script>

@endsection

