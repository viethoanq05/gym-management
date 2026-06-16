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

        // 3. Doanh thu (giả định cột amount trong bảng payments)
        $totalRevenue = DB::table('payments')->sum('amount');

        // 4. Lượt check-in trong ngày hôm nay
        $totalCheckIns = DB::table('checkins')
            ->whereDate('checkin_time', Carbon::today())
            ->count();

        // 5. Hoạt động mới (Lấy 4 lịch đặt gần nhất) - Đã sửa lỗi JOIN 2 lần
        $recentActivities = DB::table('bookings')
            ->join('members', 'bookings.member_id', '=', 'members.id')
            ->join('users', 'members.user_id', '=', 'users.id')
            ->select('bookings.*', 'users.name as user_name')
            ->orderBy('bookings.created_at', 'desc')
            ->limit(4)
            ->get();

        // Truyền chính xác tên biến $recentActivities sang giao diện
        return view('admin.dashboard', compact(
            'totalMembers',
            'totalNewMembers',
            'totalRevenue',
            'totalCheckIns',
            'recentActivities'
        ));
    }
}
