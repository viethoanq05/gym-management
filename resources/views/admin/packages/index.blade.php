@extends('layouts.admin')
@section('title', 'Danh sách gói tập')
@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span class="separator">/</span>
                <span class="text-slate-300">Gói tập</span>
            </div>
            <h2 class="page-title">Danh sách gói tập</h2>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="btn-primary">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Thêm gói tập
        </a>
    </div>

    {{-- Table --}}
    <div class="glass-card p-0 overflow-hidden animate-fade-in-up">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên gói</th>
                        <th>Giá tiền</th>
                        <th>Thời hạn (ngày)</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                    <tr>
                        <td>
                            <span class="text-slate-400 font-mono text-xs">#{{ $package->id }}</span>
                        </td>
                        <td>
                            <span class="font-medium text-white">{{ $package->name }}</span>
                        </td>
                        <td>
                            <span class="text-emerald-400 font-semibold">{{ number_format($package->price) }} đ</span>
                        </td>
                        <td>
                            <span class="text-slate-300">{{ $package->duration_days }} ngày</span>
                        </td>
                        <td>
                            @if($package->status == 1)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn-action btn-action-edit" title="Sửa">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa gói tập này?');">
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
                                <svg class="w-12 h-12 text-slate-600 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                                <p class="text-slate-500">Không có gói tập nào</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($packages->hasPages())
        <div class="px-5 py-4 border-t border-white/5">
            {{ $packages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection