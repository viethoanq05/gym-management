<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thêm Hội Viên Mới - IRON CORE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 font-sans">

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

    <main class="max-w-4xl mx-auto mt-8 p-4">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-800 px-8 py-5 text-white">
                <h1 class="text-xl font-bold">Thêm Hồ Sơ Hội Viên Mới</h1>
                <p class="text-sm text-slate-300 mt-1">Điền đầy đủ thông tin để khởi tạo tài khoản và hồ sơ hội viên.</p>
            </div>

            <div class="p-8">
                @if($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-600 border border-red-100">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('staff.members.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <div class="space-y-5">
                            <h3 class="text-base font-bold text-blue-600 border-b border-slate-100 pb-2">1. Thông tin Tài khoản</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Họ và Tên <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Số điện thoại <span class="text-red-500">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Địa chỉ Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Mật khẩu khởi tạo <span class="text-red-500">*</span></label>
                                <input type="password" name="password" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                            </div>
                        </div>

                        <div class="space-y-5">
                            <h3 class="text-base font-bold text-blue-600 border-b border-slate-100 pb-2">2. Chỉ số Cơ thể & Đăng ký</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Giới tính <span class="text-red-500">*</span></label>
                                    <select name="gender" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-600 outline-none text-sm bg-white">
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Ngày sinh <span class="text-red-500">*</span></label>
                                    <input type="date" name="dob" value="{{ old('dob') }}" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-600 outline-none text-sm text-slate-700">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Chiều cao (cm)</label>
                                    <input type="number" step="0.1" name="height" value="{{ old('height') }}" placeholder="VD: 168.0" class="w-full rounded-md border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Cân nặng (kg)</label>
                                    <input type="number" step="0.1" name="weight" value="{{ old('weight') }}" placeholder="VD: 62.5" class="w-full rounded-md border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Ngày tham gia <span class="text-red-500">*</span></label>
                                <input type="date" name="join_date" value="{{ old('join_date', \Carbon\Carbon::today()->format('Y-m-d')) }}" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                            </div>
                        </div>

                    </div>

                    <div class="mt-10 border-t border-slate-100 pt-6 flex justify-end gap-3">
                        <a href="{{ route('staff.dashboard') }}" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">Hủy bỏ</a>
                        <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-sm">
                            Lưu Hồ Sơ Hội Viên ✔
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </main>

</body>
</html>