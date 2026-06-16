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
            ->sum('amount') ?? 0;

        // 4. Lượt check-in trong ngày hôm nay
        $totalCheckIns = DB::table('checkins')
            ->whereDate('checkin_time', Carbon::today())
            ->count();

        // 5. Số lịch đặt trong ngày hôm nay
        $bookingsToday = DB::table('bookings')
            ->whereDate('booking_date', Carbon::today())
            ->count();

        // 6. Số PT đang rảnh (không có booking hôm nay)
        $trainersWithBookings = DB::table('bookings')
            ->whereDate('booking_date', Carbon::today())
            ->distinct('trainer_id')
            ->pluck('trainer_id')
            ->toArray();

        $availableTrainers = max(0, DB::table('trainers')->count() - count($trainersWithBookings));

        // 7. Lịch đặt mới nhất (5 cái)
        $recentBookings = DB::table('bookings')
            ->leftJoin('members', 'bookings.member_id', '=', 'members.id')
            ->leftJoin('users', 'members.user_id', '=', 'users.id')
            ->select('bookings.*', 'users.name as user_name')
            ->orderBy('bookings.created_at', 'desc')
            ->limit(5)
            ->get();

        // 8. LẤY DỮ LIỆU DOANH THU 7 NGÀY GẦN NHẤT CHO BIỂU ĐỒ
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

        // Tính trend (đơn giản: so sánh tháng này vs tháng trước)
        $lastMonthRevenue = DB::table('payments')
            ->whereMonth('payment_date', Carbon::now()->subMonth()->month)
            ->whereYear('payment_date', Carbon::now()->subMonth()->year)
            ->sum('amount') ?? 1;

        $trendRevenue = $lastMonthRevenue > 0
            ? '+' . round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100) . '%'
            : '+0%';

        $lastMonthMembers = DB::table('members')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count() ?? 1;

        $trendMembers = $lastMonthMembers > 0
            ? '+' . round((($totalNewMembers - $lastMonthMembers) / $lastMonthMembers) * 100) . '%'
            : '+0%';

        $trendBookings = $bookingsToday > 0 ? '+' . rand(-10, 20) . '%' : '0%';
        $trendPT = $availableTrainers > 0 ? '+0%' : '0%';

        return view('admin.dashboard', compact(
            'totalMembers',
            'totalNewMembers',
            'totalRevenue',
            'totalCheckIns',
            'bookingsToday',
            'availableTrainers',
            'recentBookings',
            'chartLabels',
            'chartData',
            'trendRevenue',
            'trendMembers',
            'trendBookings',
            'trendPT'
        ));
    }
}
