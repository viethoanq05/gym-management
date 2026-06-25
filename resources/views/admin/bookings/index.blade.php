@extends('layouts.admin')
@section('title', 'Danh sách đặt lịch')
@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span class="separator">/</span>
                <span class="text-slate-300">Đặt lịch</span>
            </div>
            <h2 class="page-title">Danh sách đặt lịch</h2>
        </div>
        <a href="{{ route('admin.bookings.create') }}" class="btn-primary">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Thêm đặt lịch
        </a>
    </div>

    {{-- Table --}}
    <div class="glass-card p-0 overflow-hidden animate-fade-in-up">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Hội viên</th>
                        <th>PT</th>
                        <th>Ngày tập</th>
                        <th>Khung giờ</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                    {{ strtoupper(substr(optional($booking->member->user)->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="font-medium text-white">{{ optional($booking->member->user)->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-slate-300">{{ optional($booking->trainer->user)->name ?? '—' }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2 text-slate-300">
                                <svg class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $booking->booking_date }}
                            </div>
                        </td>
                        <td>
                            <span class="text-slate-300">{{ $booking->start_time }} - {{ $booking->end_time }}</span>
                        </td>
                        <td>
                            @if($booking->status == 1)
                                <span class="badge badge-info">Đã xác nhận</span>
                            @elseif($booking->status == 2)
                                <span class="badge badge-warning">Chờ duyệt</span>
                            @else
                                <span class="badge badge-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn-action btn-action-edit" title="Sửa">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đặt lịch này?');">
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
                        <td colspan="6" class="!p-0">
                            <div class="empty-state">
                                <svg class="w-12 h-12 text-slate-600 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <p class="text-slate-500">Không có lịch đặt nào</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
        <div class="px-5 py-4 border-t border-white/5">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection