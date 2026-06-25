@extends('layouts.admin')

@section('title', 'Danh sách gói tập')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Gói tập</h2>
        <a href="{{ route('admin.packages.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-md text-sm">Thêm gói tập</a>
    </div>

    <div class="rounded-2xl bg-white p-4 shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-xs text-slate-500">
                    <tr>
                        <th class="text-left py-2">ID</th>
                        <th class="text-left py-2">Tên gói</th>
                        <th class="text-left py-2">Giá tiền</th>
                        <th class="text-left py-2">Thời hạn</th>
                        <th class="text-left py-2">Trạng thái</th>
                        <th class="text-left py-2">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($packages as $package)
                    <tr class="border-t">
                        <td class="py-3">{{ $package->id }}</td>
                        <td class="py-3">{{ $package->name }}</td>
                        <td class="py-3">{{ number_format($package->price, 0, ',', '.') }} đ</td>
                        <td class="py-3">{{ $package->duration_days }} ngày</td>
                        <td class="py-3">
                            @if($package->status === 1)
                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs text-emerald-700">Active</span>
                            @else
                            <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs text-rose-700">Inactive</span>
                            @endif
                        </td>
                        <td class="py-3">
                            <a href="{{ route('admin.packages.edit', $package->id) }}" class="text-sm text-blue-600 mr-3">Sửa</a>
                            <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bản ghi này?');">
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
        <div class="mt-4">{{ $packages->links() }}</div>
    </div>
</div>
@endsection