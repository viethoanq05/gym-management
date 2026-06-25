@extends('layouts.admin')

@section('title', 'Giao dịch')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Giao dịch</h2>
        <a href="{{ route('admin.payments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <span>+ Tạo giao dịch</span>
        </a>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition">
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold text-slate-600 border-b">
                        <th class="pb-4">Mã GD</th>
                        <th class="pb-4">Tên hội viên</th>
                        <th class="pb-4">Gói tập</th>
                        <th class="pb-4">Số tiền</th>
                        <th class="pb-4">Ngày TT</th>
                        <th class="pb-4">PT thanh toán</th>
                        <th class="pb-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if($payments->isNotEmpty())
                    @foreach($payments as $payment)
                    <tr class="border-t hover:bg-slate-50">
                        <td class="py-4">#{{ $payment->id }}</td>
                        <td class="py-4">{{ $payment->membership->member->user->name ?? 'N/A' }}</td>
                        <td class="py-4">{{ $payment->membership->package->name ?? 'N/A' }}</td>
                        <td class="py-4 font-semibold text-green-700">{{ number_format($payment->amount, 0, ',', '.') }} đ</td>
                        <td class="py-4">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                        <td class="py-4">
                            @php
                            $methods = [1 => 'Tiền mặt', 2 => 'Thẻ tín dụng', 3 => 'Chuyển khoản'];
                            @endphp
                            <span class=\"inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800\">
                                {{ $methods[$payment->payment_method] ?? 'Khác' }}
                            </span>
                        </td>
                        <td class="py-4">
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa giao dịch này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="py-8">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-12 w-12 text-slate-300 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-sm text-slate-500">Chưa có giao dịch nào</p>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
        <div class="mt-6 flex items-center justify-between">
            <p class="text-sm text-slate-600">
                Hiển thị <span class="font-semibold">{{ $payments->firstItem() }}</span> đến <span class="font-semibold">{{ $payments->lastItem() }}</span> trong <span class="font-semibold">{{ $payments->total() }}</span> kết quả
            </p>
            <div class="flex gap-2">
                {{ $payments->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection