@extends('layouts.admin')

@section('title', 'Thêm giao dịch')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-semibold">Thêm giao dịch</h2>

    <form id="payment-form" action="{{ route('admin.payments.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Hội viên</label>
                <select name="member_id" class="mt-1 w-full border rounded px-3 py-2 @error('member_id') border-red-500 bg-rose-50 @enderror">
                    <option value="">Chọn hội viên</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->user->name ?? 'Hội viên #' . $member->id }}
                    </option>
                    @endforeach
                </select>
                @error('member_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Gói tập</label>
                <select id="package_id" name="package_id" class="mt-1 w-full border rounded px-3 py-2 @error('package_id') border-red-500 bg-rose-50 @enderror">
                    <option value="">Chọn gói tập</option>
                    @foreach($packages as $package)
                    <option value="{{ $package->id }}" data-price="{{ $package->price }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                        {{ $package->name }} — {{ number_format($package->price, 0, ',', '.') }} đ
                    </option>
                    @endforeach
                </select>
                @error('package_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Số tiền</label>
                <input id="amount_display" type="text" value="{{ old('amount') ? number_format((float) old('amount'), 2, ',', '.') : '' }}" class="mt-1 w-full border rounded px-3 py-2 @error('amount') border-red-500 bg-rose-50 @enderror" />
                <input id="amount" name="amount" type="hidden" value="{{ old('amount') }}" />
                @error('amount')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Phương thức thanh toán</label>
                <select name="payment_method" class="mt-1 w-full border rounded px-3 py-2 @error('payment_method') border-red-500 bg-rose-50 @enderror">
                    <option value="">Chọn phương thức</option>
                    <option value="1" {{ old('payment_method') == '1' ? 'selected' : '' }}>Tiền mặt</option>
                    <option value="2" {{ old('payment_method') == '2' ? 'selected' : '' }}>Thẻ tín dụng</option>
                    <option value="3" {{ old('payment_method') == '3' ? 'selected' : '' }}>Chuyển khoản</option>
                </select>
                @error('payment_method')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Ngày thanh toán</label>
                <input name="payment_date" type="date" value="{{ old('payment_date', now()->format('Y-m-d')) }}" class="mt-1 w-full border rounded px-3 py-2 @error('payment_date') border-red-500 bg-rose-50 @enderror" />
                @error('payment_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 border rounded">Huỷ</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Tạo giao dịch</button>
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