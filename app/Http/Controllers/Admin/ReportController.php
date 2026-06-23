<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\RevenueExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Parse date range: default from start of current month to today
        $startDate = $request->query('start_date')
            ? Carbon::parse($request->query('start_date'))->startOfDay()
            : Carbon::today()->startOfMonth();

        $endDate = $request->query('end_date')
            ? Carbon::parse($request->query('end_date'))->endOfDay()
            : Carbon::today()->endOfDay();

        // Revenue grouped by package
        // payments -> memberships -> packages (payments reference membership_id)
        $revenueByPackage = DB::table('payments')
            ->join('memberships', 'payments.membership_id', '=', 'memberships.id')
            ->join('packages', 'memberships.package_id', '=', 'packages.id')
            ->select(
                'packages.id as package_id',
                'packages.name as package_name',
                DB::raw('SUM(payments.amount) as total_revenue'),
                DB::raw('COUNT(payments.id) as payments_count')
            )
            ->whereBetween('payment_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy('packages.id', 'packages.name')
            ->orderByDesc('total_revenue')
            ->get();

        // Top trainers by bookings
        $topTrainers = DB::table('bookings')
            ->join('trainers', 'bookings.trainer_id', '=', 'trainers.id')
            ->leftJoin('users', 'trainers.user_id', '=', 'users.id')
            ->select(
                'trainers.id as trainer_id',
                'users.name as trainer_name',
                DB::raw('COUNT(bookings.id) as bookings_count')
            )
            ->whereBetween('booking_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy('trainers.id', 'users.name')
            ->orderByDesc('bookings_count')
            ->get();

        // Peak check-in hours
        $peakHours = DB::table('checkins')
            ->select(DB::raw('HOUR(checkin_time) as hour'), DB::raw('COUNT(*) as checkin_count'))
            ->whereBetween('checkin_time', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->groupBy(DB::raw('HOUR(checkin_time)'))
            ->orderByDesc('checkin_count')
            ->get();

        return view('admin.reports.index', compact('revenueByPackage', 'topTrainers', 'peakHours', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        $startDate = $request->query('start_date')
            ? Carbon::parse($request->query('start_date'))->startOfDay()->toDateString()
            : Carbon::today()->startOfMonth()->toDateString();

        $endDate = $request->query('end_date')
            ? Carbon::parse($request->query('end_date'))->endOfDay()->toDateString()
            : Carbon::today()->toDateString();

        return Excel::download(new RevenueExport($startDate, $endDate), 'Bao_cao_doanh_thu.xlsx');
    }
}
