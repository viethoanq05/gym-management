@php $colCount = is_array($columns) ? count($columns) : 0; @endphp
<div class="rounded-2xl bg-white p-4 shadow">
    <div class="flex items-center justify-between mb-4">
        <div class="text-sm text-slate-500">{{ $title ?? '' }}</div>
        <div>
            @if(!empty($createUrl))
            <a href="{{ $createUrl }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm">Thêm mới</a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-xs text-slate-500">
                <tr>
                    @foreach($columns as $col)
                    <th class="text-left py-2">{{ $col }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($items as $item)
                <tr class="border-t">
                    @foreach($fields as $field)
                    <td class="py-3">{{ data_get($item, $field, '—') }}</td>
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $colCount }}" class="py-4 text-center text-slate-500">Không có dữ liệu</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>