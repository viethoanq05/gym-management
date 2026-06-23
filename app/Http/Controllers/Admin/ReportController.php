<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Thêm dòng này để dùng Query Builder
use App\Models\Payment;
use App\Models\Booking;
use App\Exports\RevenueExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. ĐỒNG BỘ THỜI GIAN
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();

        // 2. DOANH THU THEO GÓI (Giữ nguyên Eloquent an toàn với Nullsafe)
        $payments = Payment::whereBetween('payment_date', [$startDate, $endDate])->get();

        $revenueByPackage = $payments->groupBy(function ($payment) {
            return $payment->package?->name ?? $payment->membership?->package?->name ?? 'Gói mặc định / Khác';
        })->map(function ($group, $name) {
            return (object) [
                'package_name' => $name,
                'total_revenue' => $group->sum('amount')
            ];
        })->values();

        // 3. TOP HLV ĐƯỢC BOOK (Đã fix lỗi thời gian và Business Logic)
        $bookings = DB::table('bookings')
            // BÍ QUYẾT: Dùng 'created_at' để tính những lịch được "TẠO RA" trong khoảng thời gian này
            // Nếu bạn bắt buộc muốn thống kê theo "Ngày tập", hãy đổi lại thành 'booking_date'
            // và dùng $startDate->toDateString() để an toàn với cột DATE.
            ->whereBetween('created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->get();

        // Lấy sẵn danh sách HLV và User để ghép tên thủ công (Cực kỳ an toàn)
        $trainers = DB::table('trainers')->get()->keyBy('id');
        $users = DB::table('users')->get()->keyBy('id');

        $topTrainers = collect($bookings)->groupBy('trainer_id')->map(function ($group, $trainerId) use ($trainers, $users) {
            $trainer = $trainers->get($trainerId);
            $trainerName = 'HLV ẩn danh #' . $trainerId; // Giá trị mặc định nếu mất data

            // Dò tìm tên thật của HLV qua các bảng
            if ($trainer && isset($trainer->user_id)) {
                $user = $users->get($trainer->user_id);
                if ($user && isset($user->name)) {
                    $trainerName = $user->name;
                }
            }

            return (object) [
                'trainer_id' => $trainerId,
                'trainer_name' => $trainerName,
                'bookings_count' => $group->count(),
            ];
        })->sortByDesc('bookings_count')->take(5)->values();

        // 4. CHECK-IN THEO KHUNG GIỜ
        $peakHours = DB::table('checkins')
            ->whereBetween('checkin_time', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->selectRaw('HOUR(checkin_time) as hour, COUNT(id) as checkin_count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Trả về View
        return view('admin.reports.index', compact('revenueByPackage', 'topTrainers', 'peakHours', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()->toDateString()
            : Carbon::now()->startOfMonth()->toDateString();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()->toDateString()
            : Carbon::now()->toDateString();

        return Excel::download(new RevenueExport($startDate, $endDate), 'Bao_cao_doanh_thu.xlsx');
    }
}
