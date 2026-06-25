<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dashboardMetrics = [];

        if ($user && $user->role === 'admin') {
            $dashboardMetrics = $this->getDashboardMetrics();
        } else {
            $dashboardMetrics = [
                'totalMembers' => 0,
                'totalNewMembers' => 0,
                'totalRevenue' => 0,
                'chartLabels' => [],
                'chartData' => [],
                'expiringMembers' => collect(),
                'trendRevenue' => '+0%',
                'trendMembers' => '+0%',
            ];
        }

        $totalMembers = $dashboardMetrics['totalMembers'];
        $totalNewMembers = $dashboardMetrics['totalNewMembers'];
        $totalRevenue = $dashboardMetrics['totalRevenue'];
        $chartLabels = $dashboardMetrics['chartLabels'];
        $chartData = $dashboardMetrics['chartData'];
        $trendRevenue = $dashboardMetrics['trendRevenue'];
        $trendMembers = $dashboardMetrics['trendMembers'];
        $expiringMembers = $dashboardMetrics['expiringMembers'];

        $totalCheckIns = DB::table('checkins')
            ->whereDate('checkin_time', Carbon::today())
            ->count();

        $bookingsToday = DB::table('bookings')
            ->whereDate('booking_date', Carbon::today())
            ->count();

        $trainersWithBookings = DB::table('bookings')
            ->whereDate('booking_date', Carbon::today())
            ->distinct('trainer_id')
            ->pluck('trainer_id')
            ->toArray();

        $availableTrainers = max(0, DB::table('trainers')->count() - count($trainersWithBookings));

        $recentBookings = DB::table('bookings')
            ->leftJoin('members', 'bookings.member_id', '=', 'members.id')
            ->leftJoin('users', 'members.user_id', '=', 'users.id')
            ->select('bookings.*', 'users.name as user_name')
            ->orderBy('bookings.created_at', 'desc')
            ->limit(5)
            ->get();

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
            'trendPT',
            'expiringMembers'
        ));
    }

    public function getDashboardData(Request $request)
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $filter = $request->query('filter', 'this_month');

        // Lấy dữ liệu trực tiếp, bypass hoàn toàn Cache
        $metrics = $this->buildDashboardMetrics($filter);

        return response()->json(['data' => $metrics]);
    }

    protected function getDashboardMetrics(string $filter = 'this_month'): array
    {
        // Lấy dữ liệu trực tiếp, bypass hoàn toàn Cache
        return $this->buildDashboardMetrics($filter);
    }

    protected function buildDashboardMetrics(string $filter): array
    {
        $today = Carbon::today();
        $currentMonth = $today->month;
        $currentYear = $today->year;
        $lastMonth = $today->copy()->subMonth();

        $totalMembers = DB::table('members')->count();
        $totalNewMembers = DB::table('members')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        if ($filter === 'this_month') {
            $startDate = $today->copy()->startOfMonth();
            $endDate = $today;
        } elseif ($filter === 'this_quarter') {
            $startDate = $today->copy()->firstOfQuarter();
            $endDate = $today;
        } else {
            $startDate = $today->copy()->subDays(6);
            $endDate = $today;
        }

        // Mở rộng mốc thời gian để không bị rớt dữ liệu ngày hôm nay
        $startStr = $startDate->copy()->startOfDay()->toDateTimeString();
        $endStr = $endDate->copy()->endOfDay()->toDateTimeString();

        $totalRevenue = DB::table('payments')
            ->whereBetween('payment_date', [$startStr, $endStr])
            ->sum('amount') ?? 0;

        $paymentByDay = DB::table('payments')
            ->select(DB::raw('DATE(payment_date) as date'), DB::raw('SUM(amount) as total_amount'))
            ->whereBetween('payment_date', [$startStr, $endStr])
            ->groupBy(DB::raw('DATE(payment_date)'))
            ->orderBy('date')
            ->pluck('total_amount', 'date')
            ->toArray();

        $chartLabels = [];
        $chartData = [];
        $period = $startDate->copy();
        while ($period->lte($endDate)) {
            $chartLabels[] = $period->format('d/m');
            $key = $period->toDateString();
            $chartData[] = isset($paymentByDay[$key]) ? (float) $paymentByDay[$key] : 0;
            $period->addDay();
        }

        $lastMonthRevenue = DB::table('payments')
            ->whereMonth('payment_date', $lastMonth->month)
            ->whereYear('payment_date', $lastMonth->year)
            ->sum('amount') ?? 1;

        $trendRevenue = $lastMonthRevenue > 0
            ? '+' . round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100) . '%'
            : '+0%';

        $lastMonthMembers = DB::table('members')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count() ?? 1;

        $trendMembers = $lastMonthMembers > 0
            ? '+' . round((($totalNewMembers - $lastMonthMembers) / $lastMonthMembers) * 100) . '%'
            : '+0%';

        // Members with memberships expiring within next 7 days
        $expiringMembers = DB::table('memberships')
            ->join('members', 'memberships.member_id', '=', 'members.id')
            ->join('users', 'members.user_id', '=', 'users.id')
            ->select('members.id as member_id', 'users.name', 'memberships.end_date')
            ->whereBetween('memberships.end_date', [Carbon::today()->toDateString(), Carbon::today()->addDays(7)->toDateString()])
            ->orderBy('memberships.end_date')
            ->get();

        return [
            'totalMembers' => $totalMembers,
            'totalNewMembers' => $totalNewMembers,
            'totalRevenue' => $totalRevenue,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'trendRevenue' => $trendRevenue,
            'trendMembers' => $trendMembers,
            'expiringMembers' => $expiringMembers,
        ];
    }
}
