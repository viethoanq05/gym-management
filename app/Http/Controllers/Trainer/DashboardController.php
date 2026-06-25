<?php

namespace App\Http\Controllers\Trainer;

use App\Models\Trainer;
use App\Models\Booking;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $trainer = Trainer::where('user_id', Auth::id())->first();

        if (!$trainer) {
            return redirect()->route('login');
        }

        // Số giờ dạy
        $totalTeachingHours = $this->getTotalTeachingHours($trainer);

        // Số hội viên phụ trách
        $activeMembersCount = Booking::where('trainer_id', $trainer->id)
            ->distinct('member_id')
            ->count('member_id');

        // Tổng số buổi dạy đã xác nhận
        $totalSessions = Booking::where('trainer_id', $trainer->id)
            ->where('status', 1) // confirmed
            ->count();

        // Lịch tới trong 7 ngày
        $upcomingSchedules = Booking::where('trainer_id', $trainer->id)
            ->where('booking_date', '>=', Carbon::today())
            ->where('booking_date', '<=', Carbon::today()->addDays(7))
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();

        return view('trainer.dashboard', [
            'trainer' => $trainer,
            'totalTeachingHours' => $totalTeachingHours,
            'activeMembersCount' => $activeMembersCount,
            'totalSessions' => $totalSessions,
            'upcomingSchedules' => $upcomingSchedules,
        ]);
    }

    private function getTotalTeachingHours(Trainer $trainer): float
    {
        $bookings = Booking::where('trainer_id', $trainer->id)
            ->where('status', 1) // confirmed
            ->get();

        $totalHours = 0;
        foreach ($bookings as $booking) {
            $start = strtotime($booking->start_time);
            $end = strtotime($booking->end_time);
            $hours = ($end - $start) / 3600;
            $totalHours += $hours;
        }

        return round($totalHours, 2);
    }
}
