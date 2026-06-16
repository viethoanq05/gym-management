<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Tổng hội viên
        $totalMembers = DB::table('members')->count();

        // 2. Hội viên mới trong tháng này
        $totalNewMembers = DB::table('members')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // 3. Doanh thu trong tháng này
        $totalRevenue = DB::table('payments')
            ->whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');

        // 4. Lượt check-in trong ngày hôm nay
        $totalCheckIns = DB::table('checkins')
            ->whereDate('checkin_time', Carbon::today())
            ->count();

        // 5. Hoạt động đặt lịch mới nhất
        $recentActivities = DB::table('bookings')
            ->join('members', 'bookings.member_id', '=', 'members.id')
            ->join('users', 'members.user_id', '=', 'users.id')
            ->select('bookings.*', 'users.name as user_name')
            ->orderBy('bookings.created_at', 'desc')
            ->limit(4)
            ->get();

        // 6. LẤY DỮ LIỆU DOANH THU 7 NGÀY GẦN NHẤT CHO BIỂU ĐỒ
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d/m');

            // Tính tổng số tiền giao dịch của ngày đó
            $chartData[] = DB::table('payments')
                ->whereDate('payment_date', $date)
                ->sum('amount') ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalMembers',
            'totalNewMembers',
            'totalRevenue',
            'totalCheckIns',
            'recentActivities',
            'chartLabels',
            'chartData'
        ));
    }
}
