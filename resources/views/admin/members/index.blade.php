@extends('layouts.admin')

@section('title', 'Danh sách hội viên')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Hội viên</h2>
        <div>
            <a href="{{ route('admin.members.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-md text-sm">Thêm hội viên</a>
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
                        <th class="text-left py-2">Ngày gia nhập</th>
                        <th class="text-left py-2">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($members as $member)
                    <tr class="border-t">
                        <td class="py-3">{{ $member->id }}</td>
                        <td class="py-3">{{ $member->name }}</td>
                        <td class="py-3">{{ $member->email }}</td>
                        <td class="py-3">{{ $member->phone }}</td>
                        <td class="py-3">
                            {{ optional($member->member)->join_date
                                ? optional($member->member)->join_date->format('Y-m-d')
                                : $member->created_at->format('Y-m-d') }}
                        </td>
                        <td class="py-3">
                            <a href="{{ route('admin.members.edit', $member->id) }}" class="text-sm text-blue-600 mr-3">Sửa</a>
                            <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xoá hội viên này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-slate-500">Không có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $members->links() }}</div>
    </div>
</div>

@endsection