@extends('layouts.admin')

@section('title', 'Danh sách hội viên')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Hội viên</h2>
        <div>
            <a href="{{ route('admin.members.create') ?? '#' }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-md text-sm">Thêm hội viên</a>
        </div>
    </div>

    @include('components.admin.datatable', [
    'title' => 'Danh sách hội viên',
    'createUrl' => route('admin.members.create') ?? '#',
    'columns' => ['ID', 'Tên', 'Email', 'SĐT', 'Ngày gia nhập', 'Hành động'],
    'fields' => ['id', 'name', 'email', 'phone', 'created_at', 'id'],
    'items' => $members ?? collect([]),
    ])

    @push('scripts')
    <script>
        // Placeholder for datatable JS (sorting, ajax, etc.)
    </script>
    @endpush
</div>

@endsection