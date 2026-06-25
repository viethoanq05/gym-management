<?php

namespace App\Http\Controllers\Trainer;

use App\Models\Trainer;
use App\Models\Booking;
use App\Models\TrainerPoint;
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

        // Điểm cộng
        $bonusPoints = TrainerPoint::where('trainer_id', $trainer->id)
            ->where('type', 'bonus')
            ->sum('points');

        // Điểm trừ
        $penaltyPoints = TrainerPoint::where('trainer_id', $trainer->id)
            ->where('type', 'penalty')
            ->sum('points');

        $totalPoints = $bonusPoints - $penaltyPoints;

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
            'bonusPoints' => $bonusPoints,
            'penaltyPoints' => $penaltyPoints,
            'totalPoints' => $totalPoints,
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
