@extends('layouts.admin')

@section('title', 'Danh sách nhân viên')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Nhân viên</h2>
        <div>
            <a href="{{ route('admin.staff.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-md text-sm">Thêm nhân viên</a>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-4 shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-xs text-slate-500">
                    <tr>
                        <th class="text-left py-2">ID</th>
                        <th class="text-left py-2">Tên</th>
                        <th class="text-left py-2">Email</th>
                        <th class="text-left py-2">SĐT</th>
                        <th class="text-left py-2">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($staff as $s)
                    <tr class="border-t">
                        <td class="py-3">{{ $s->id }}</td>
                        <td class="py-3">{{ $s->name }}</td>
                        <td class="py-3">{{ $s->email }}</td>
                        <td class="py-3">{{ $s->phone }}</td>
                        <td class="py-3">
                            <a href="{{ route('admin.staff.edit', $s->id) }}" class="text-sm text-blue-600 mr-3">Sửa</a>
                            <form action="{{ route('admin.staff.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xoá nhân viên này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-slate-500">Không có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $staff->links() }}</div>
    </div>
</div>

@endsection