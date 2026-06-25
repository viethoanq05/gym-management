<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý lịch tập - IRON CORE</title>
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

    <main class="max-w-4xl mx-auto mt-10 p-4">
        <div class="rounded-xl bg-white p-8 shadow-xl border border-slate-100">
            
            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-slate-800">Xác nhận lịch tập</h1>
                <p class="text-sm text-slate-500 mt-1">Danh sách yêu cầu đặt lịch tập luyện với PT từ hội viên.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-600 border border-emerald-100 font-medium">
                    ✔ {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-lg border border-slate-100 shadow-sm">
                <table class="w-full border-collapse bg-white text-left text-sm text-slate-500">
                    <thead class="bg-slate-50 font-bold text-slate-700 uppercase text-xs tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Hội viên</th>
                            <th class="px-6 py-4">Ngày tập</th>
                            <th class="px-6 py-4">Khung giờ</th>
                            <th class="px-6 py-4">Trạng thái</th>
                            <th class="px-6 py-4 text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 border-t border-slate-100">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $booking->member->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-600">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                </td>

                                <td class="px-6 py-4">
                                    @if($booking->status == 1)
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                            Đã xác nhận
                                        </span>
                                    @elseif($booking->status == 3)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                            Đã hoàn thành
                                        </span>
                                    @elseif($booking->status == 0)
                                        <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                            Đã hủy
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                            Chờ duyệt
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right">
                                    @if($booking->status == 1)
                                        <form method="POST" action="{{ route('staff.schedules.confirm', $booking->id) }}">
                                            @csrf
                                            <button type="submit" class="rounded-md bg-emerald-600 px-3 py-1.5 text-xs font-bold text-white hover:bg-emerald-700 transition shadow-sm">
                                                Đã tập ✔
                                            </button>
                                        </form>
                                    @elseif($booking->status == 3)
                                        <span class="text-xs font-medium text-slate-400 italic">Hoàn tất</span>
                                    @elseif($booking->status == 0)
                                        <span class="text-xs font-medium text-slate-400 italic">Đã hủy</span>
                                    @else
                                        <span class="text-xs font-medium text-slate-400 italic">Chờ PT duyệt</span>
                                    @endif
                                </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-400 italic">
                                    Không có yêu cầu đặt lịch nào hiện tại.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>
</html>