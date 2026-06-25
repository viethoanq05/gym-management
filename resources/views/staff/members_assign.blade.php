<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gán Gói Tập - IRON CORE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 p-6">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-6 mt-10">
        <h2 class="text-xl font-bold text-slate-800 mb-2">Chọn gói cho hội viên</h2>

        <form method="POST" action="{{ route('staff.memberships.assign.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Chọn Hội Viên</label>
                <select name="member_id" required class="w-full rounded-md border border-slate-300 px-3 py-2 bg-white text-sm">
                    <option value="" disabled selected>-- Chọn hội viên --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->member_id }}">
                            {{ $member->name }} ({{ $member->phone }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Chọn Gói Tập</label>
                <select name="package_id" required class="w-full rounded-md border border-slate-300 px-3 py-2 bg-white text-sm">
                    @foreach($packages as $package)
                        <option value="{{ $package->id }}">
                            {{ $package->name }} ({{ number_format($package->price, 0, ',', '.') }}đ)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-4 flex justify-end gap-2">
                <a href="{{ route('staff.memberships') }}" class="px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded">Hủy</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-bold text-sm rounded hover:bg-blue-700">Tạo Đăng Ký</button>
            </div>
        </form>
    </div>
</body>
</html>