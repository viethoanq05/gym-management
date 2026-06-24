<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý gói tập - IRON CORE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50">

    <nav class="bg-white shadow-sm px-6 py-4 flex justify-between items-center border-b border-slate-100">
        <div class="flex items-center gap-2">
            <span class="font-extrabold text-lg text-blue-600">IRON CORE</span>
            <span class="text-slate-300">|</span>
            <span class="text-sm font-medium text-slate-600">Quản lý nhân viên</span>
        </div>
        <a href="{{ route('staff.dashboard') }}" class="text-sm font-medium text-blue-600 hover:underline">
            ← Quay lại Bảng điều khiển
        </a>
    </nav>

    <main class="max-w-5xl mx-auto mt-10 p-4">
        <div class="rounded-xl bg-white p-8 shadow-xl border border-slate-100">
            
            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-slate-800">Duyệt & Quản lý gói tập</h1>
                <p class="text-sm text-slate-500 mt-1">Xử lý đăng ký mua gói, tạm hoãn thời hạn, hoặc hủy dịch vụ của hội viên.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-600 border border-emerald-100 font-medium shadow-sm">
                    ✔ {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-lg border border-slate-100 shadow-sm">
                <table class="w-full border-collapse bg-white text-left text-sm text-slate-500">
                    <thead class="bg-slate-50 font-bold text-slate-700 uppercase text-xs tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Hội viên</th>
                            <th class="px-6 py-4">Mã gói</th>
                            <th class="px-6 py-4">Giá tiền</th>
                            <th class="px-6 py-4">Thời hạn</th>
                            <th class="px-6 py-4">Trạng thái</th>
                            <th class="px-6 py-4 text-right">Thao tác xử lý</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 border-t border-slate-100">
                        @forelse($memberships as $ms)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $ms->member->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-600">Gói #{{ $ms->package_id }}</td>
                                <td class="px-6 py-4 font-bold text-slate-700">{{ number_format($ms->package_price, 0, ',', '.') }}đ</td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($ms->start_date)->format('d/m/Y') }} ➔ {{ \Carbon\Carbon::parse($ms->end_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($ms->status == 1)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Hoạt động</span>
                                    @elseif($ms->status == 2)
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Đang tạm dừng</span>
                                    @elseif($ms->status == 3)
                                        <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">Đã hủy bỏ</span>
                                    @elseif($ms->status == 4)
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/20">Đã từ chối</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">Chờ kích hoạt</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1.5">
                                        @if($ms->status == 0)
                                            <form method="POST" action="{{ route('staff.memberships.confirm', $ms->id) }}">
                                                @csrf
                                                <button type="submit" class="rounded bg-blue-600 px-2.5 py-1 text-xs font-bold text-white hover:bg-blue-700 transition">Duyệt mua ✔</button>
                                            </form>

                                            <form method="POST" action="{{ route('staff.memberships.reject', $ms->id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn từ chối yêu cầu đăng ký này?')">
                                                @csrf
                                                <button type="submit" class="rounded bg-slate-500 px-2.5 py-1 text-xs font-bold text-white hover:bg-slate-600 transition">Từ chối ✖</button>
                                            </form>
                                        @endif

                                        @if($ms->status == 1)
                                            <form method="POST" action="{{ route('staff.memberships.freeze', $ms->id) }}">
                                                @csrf
                                                <button type="submit" class="rounded bg-amber-500 px-2.5 py-1 text-xs font-bold text-white hover:bg-amber-600 transition">Tạm dừng ⏸</button>
                                            </form>
                                        @endif

                                        @if($ms->status == 2)
                                            <form method="POST" action="{{ route('staff.memberships.unfreeze', $ms->id) }}">
                                                @csrf
                                                <button type="submit" class="rounded bg-emerald-600 px-2.5 py-1 text-xs font-bold text-white hover:bg-emerald-700 transition">Kích hoạt lại ⏵</button>
                                            </form>
                                        @endif

                                        @if($ms->status == 1 || $ms->status == 2)
                                            <form method="POST" action="{{ route('staff.memberships.cancel', $ms->id) }}" onsubmit="return confirm('Bạn chắc chắn muốn hủy gói này?')">
                                                @csrf
                                                <button type="submit" class="rounded bg-rose-600 px-2.5 py-1 text-xs font-bold text-white hover:bg-rose-700 transition">Hủy gói ✖</button>
                                            </form>
                                        @endif
                                        
                                        @if($ms->status == 3 || $ms->status == 4)
                                            <span class="text-xs text-slate-400 italic">Đóng hồ sơ</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-400 italic">Hiện tại chưa có lượt đăng ký gói nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>
</html>