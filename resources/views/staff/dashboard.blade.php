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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('staff.checkin') }}" class="block p-6 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl transition duration-200">
                    <h3 class="font-bold text-blue-700 text-lg mb-1">Điểm danh hội viên ➔</h3>
                    <p class="text-sm text-slate-600">Tìm kiếm và duyệt check-in cho khách đến phòng tập bằng ID, Tên hoặc SĐT.</p>
                </a>

                <div class="block p-6 bg-slate-50 border border-slate-200 rounded-xl opacity-60">
                    <h3 class="font-bold text-slate-700 text-lg mb-1">Gia hạn gói tập</h3>
                    <p class="text-sm text-slate-500">Kích hoạt hoặc gia hạn hợp đồng thẻ thành viên (Sắp mắt mắt).</p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>