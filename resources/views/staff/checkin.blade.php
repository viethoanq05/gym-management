<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Điểm danh hội viên - IRON CORE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
            background: #f7f7f9;
        }
    </style>
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

    <main class="max-w-2xl mx-auto mt-10 p-4">
        <div class="rounded-xl bg-white p-8 shadow-xl border border-slate-100">
            
            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-slate-800">Điểm danh hội viên</h1>
                <p class="text-sm text-slate-500 mt-1">Nhập tên hoặc số điện thoại của hội viên để kiểm tra trạng thái thẻ tập.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-600 border border-emerald-100 font-medium shadow-sm">
                    ✔ {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('staff.search') }}" class="mb-8">
                @csrf
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input 
                            name="search" 
                            value="{{ $query ?? '' }}" 
                            type="text" 
                            required 
                            class="w-full rounded-md border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600" 
                            placeholder="Nhập Số điện thoại hoặc Tên hội viên...">
                    </div>
                    <button type="submit" class="rounded-md bg-blue-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-blue-700 transition">
                        Tìm kiếm
                    </button>
                </div>
            </form>

            @if(isset($members))
                <div class="border-t border-slate-100 pt-6">
                    <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wider mb-4">Kết quả tìm kiếm</h3>
                    
                    @if($members->isEmpty())
                        <div class="rounded-lg bg-red-50 p-4 text-sm text-red-600 border border-red-100">
                            ❌ Không tìm thấy hội viên nào khớp với thông tin: <span class="font-semibold">"{{ $query }}"</span>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($members as $member)
                                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-100 hover:border-blue-200 transition">
                                    <div>
                                        <h4 class="font-bold text-slate-800">{{ $member->user->name }}</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            SĐT: {{ $member->user->phone }} | Email: {{ $member->user->email }}
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('staff.checkin.confirm', $member->id) }}">
                                        @csrf
                                        <button type="submit" class="rounded-md bg-emerald-600 px-3 py-1.5 text-xs font-bold text-white hover:bg-emerald-700 transition shadow-sm">
                                            Vào phòng ✔
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </main>

</body>
</html>