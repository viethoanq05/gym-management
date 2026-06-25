@extends('layouts.admin')
@section('title', 'Danh sách hội viên')
@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span class="separator">/</span>
                <span class="text-slate-300">Hội viên</span>
            </div>
            <h2 class="page-title">Danh sách hội viên</h2>
        </div>
        <a href="{{ route('admin.members.create') }}" class="btn-primary">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Thêm hội viên
        </a>
    </div>

    {{-- Table --}}
    <div class="glass-card p-0 overflow-hidden animate-fade-in-up">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Ngày gia nhập</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                    <tr>
                        <td>
                            <span class="text-slate-400 font-mono text-xs">#{{ $member->id }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-white">{{ $member->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-slate-300">{{ $member->email }}</span>
                        </td>
                        <td>
                            <span class="text-slate-300">{{ $member->phone }}</span>
                        </td>
                        <td>
                            <span class="text-slate-400 text-sm">{{ $member->created_at ? $member->created_at->format('d/m/Y') : '—' }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.members.edit', $member->id) }}" class="btn-action btn-action-edit" title="Sửa">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hội viên này?');">
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
                                <svg class="w-12 h-12 text-slate-600 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4-4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                <p class="text-slate-500">Không có hội viên nào</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($members->hasPages())
        <div class="px-5 py-4 border-t border-white/5">
            {{ $members->links() }}
        </div>
        @endif
    </div>
</div>
@endsection