<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - IRON CORE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans min-h-screen">

    <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
        <span class="font-extrabold text-xl text-blue-600">IRON CORE STAFF</span>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-600 font-medium">Xin chào, Staff!</span>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto mt-10 p-6">
        <div class="bg-white rounded-xl p-8 shadow-md">
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Bảng điều khiển nhân viên</h1>
            <p class="text-slate-500 mb-6">Chọn một chức năng bên dưới để bắt đầu làm việc.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    
                <a href="{{ route('staff.checkin') }}" class="flex flex-col items-center justify-center p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:border-blue-500 transition group">
                    <span class="text-3xl mb-2">📥</span>
                    <span class="font-bold text-slate-800 group-hover:text-blue-600">Check-in Hội Viên</span>
                </a>

                <a href="{{ route('staff.schedules') }}" class="flex flex-col items-center justify-center p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:border-blue-500 transition group">
                    <span class="text-3xl mb-2">📅</span>
                    <span class="font-bold text-slate-800 group-hover:text-blue-600">Xác Nhận Lịch Tập</span>
                </a>

                <a href="{{ route('staff.memberships') }}" class="flex flex-col items-center justify-center p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:border-blue-500 transition group">
                    <span class="text-3xl mb-2">💳</span>
                    <span class="font-bold text-slate-800 group-hover:text-blue-600">Duyệt Đăng Ký Gói</span>
                </a>

            </div>
        </div>
    </main>

</body>
</html>