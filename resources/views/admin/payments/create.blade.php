@extends('layouts.admin')

@section('title', 'Thêm giao dịch')

@section('content')
<div class="space-y-6">
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <a href="{{ route('admin.payments.index') }}">Giao dịch</a>
            <span class="separator">/</span>
            <span class="text-slate-300">Thêm mới</span>
        </div>
        <h2 class="page-title">Thêm giao dịch</h2>
        <p class="page-subtitle">Tạo giao dịch thanh toán mới</p>
    </div>

    <form id="payment-form" action="{{ route('admin.payments.store') }}" method="POST" class="glass-card p-6 space-y-8 animate-fade-in-up">
        @csrf

        <div class="section-divider">
            <h3>Thông tin giao dịch</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="admin-label">Hội viên</label>
                <select name="member_id" class="admin-input admin-select @error('member_id') input-error @enderror">
                    <option value="">Chọn hội viên</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->user->name ?? 'Hội viên #' . $member->id }}
                    </option>
                    @endforeach
                </select>
                @error('member_id') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Gói tập</label>
                <select id="package_id" name="package_id" class="admin-input admin-select @error('package_id') input-error @enderror">
                    <option value="">Chọn gói tập</option>
                    @foreach($packages as $package)
                    <option value="{{ $package->id }}" data-price="{{ $package->price }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                        {{ $package->name }} — {{ number_format($package->price, 0, ',', '.') }} đ
                    </option>
                    @endforeach
                </select>
                @error('package_id') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Số tiền</label>
                <input id="amount_display" type="text" value="{{ old('amount') ? number_format((float) old('amount'), 2, ',', '.') : '' }}" class="admin-input @error('amount') input-error @enderror" placeholder="Tự động điền khi chọn gói tập" />
                <input id="amount" name="amount" type="hidden" value="{{ old('amount') }}" />
                @error('amount') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Phương thức thanh toán</label>
                <select name="payment_method" class="admin-input admin-select @error('payment_method') input-error @enderror">
                    <option value="">Chọn phương thức</option>
                    <option value="1" {{ old('payment_method') == '1' ? 'selected' : '' }}>Tiền mặt</option>
                    <option value="2" {{ old('payment_method') == '2' ? 'selected' : '' }}>Thẻ tín dụng</option>
                    <option value="3" {{ old('payment_method') == '3' ? 'selected' : '' }}>Chuyển khoản</option>
                </select>
                @error('payment_method') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Ngày thanh toán</label>
                <input name="payment_date" type="date" value="{{ old('payment_date', now()->format('Y-m-d')) }}" class="admin-input @error('payment_date') input-error @enderror" />
                @error('payment_date') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('admin.payments.index') }}" class="btn-secondary">Huỷ</a>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Tạo giao dịch
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const packageSelect = document.getElementById('package_id');
        const amountInput = document.getElementById('amount');
        const amountDisplay = document.getElementById('amount_display');
        const form = document.getElementById('payment-form');

        const formatPrice = (value) => {
            return new Intl.NumberFormat('vi-VN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(value);
        };

        packageSelect?.addEventListener('change', function() {
            const selectedOption = packageSelect.selectedOptions[0];
            const price = selectedOption?.dataset.price;

            if (price !== undefined && price !== '') {
                const numericPrice = parseFloat(price);
                if (!Number.isNaN(numericPrice)) {
                    amountInput.value = numericPrice.toFixed(2);
                    amountDisplay.value = formatPrice(numericPrice);
                    return;
                }
            }

            amountInput.value = '';
            amountDisplay.value = '';
        });

        form?.addEventListener('submit', function() {
            const rawValue = amountDisplay.value.replaceAll('.', '').replace(',', '.');
            if (rawValue !== '' && !Number.isNaN(parseFloat(rawValue))) {
                amountInput.value = parseFloat(rawValue).toFixed(2);
            }
        });
    });
</script>
@endpush
@endsection