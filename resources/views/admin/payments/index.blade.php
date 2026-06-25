@extends('layouts.admin')
@section('title', 'Giao dịch')
@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span class="separator">/</span>
                <span class="text-slate-300">Giao dịch</span>
            </div>
            <h2 class="page-title">Giao dịch</h2>
        </div>
        <a href="{{ route('admin.payments.create') }}" class="btn-primary">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Thêm giao dịch
        </a>
    </div>

    {{-- Table --}}
    <div class="glass-card p-0 overflow-hidden animate-fade-in-up">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã GD</th>
                        <th>Tên hội viên</th>
                        <th>Gói tập</th>
                        <th>Số tiền</th>
                        <th>Ngày TT</th>
                        <th>PT thanh toán</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>
                            <span class="text-slate-400 font-mono text-xs">#{{ $payment->id }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                    {{ strtoupper(substr(optional(optional(optional($payment->membership)->member)->user)->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="font-medium text-white">{{ optional(optional(optional($payment->membership)->member)->user)->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-slate-300">{{ optional(optional($payment->membership)->package)->name ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="text-emerald-400 font-semibold">{{ number_format($payment->amount) }} đ</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2 text-slate-300 text-sm">
                                <svg class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $payment->payment_date }}
                            </div>
                        </td>
                        <td>
                            @if($payment->payment_method == 1)
                                <span class="badge badge-primary">Tiền mặt</span>
                            @elseif($payment->payment_method == 2)
                                <span class="badge badge-primary">Thẻ tín dụng</span>
                            @elseif($payment->payment_method == 3)
                                <span class="badge badge-primary">Chuyển khoản</span>
                            @else
                                <span class="badge badge-primary">Khác</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa giao dịch này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-action-delete" title="Xóa">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="!p-0">
                            <div class="empty-state">
                                <svg class="w-12 h-12 text-slate-600 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                <p class="text-slate-500">Không có giao dịch nào</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
        <div class="px-5 py-4 border-t border-white/5 flex items-center justify-between">
            <p class="text-sm text-slate-400">
                Hiển thị {{ $payments->firstItem() }} đến {{ $payments->lastItem() }} trong {{ $payments->total() }} kết quả
            </p>
            <div>
                {{ $payments->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection