<?php

namespace App\Http\Controllers\Trainer;

use App\Models\Trainer;
use App\Models\Booking;
use App\Models\TrainerSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    // Xem lịch của trainer
    public function index()
    {
        $trainer = Trainer::where('user_id', Auth::id())->first();

        if (!$trainer) {
            return redirect()->route('login');
        }

        $schedules = TrainerSchedule::where('trainer_id', $trainer->id)
            ->where('work_date', '>=', Carbon::today())
            ->orderBy('work_date')
            ->orderBy('start_time')
            ->simplePaginate(10);
        return view('trainer.schedule.index', [
            'schedules' => $schedules,
            'trainer' => $trainer,
        ]);
    }

    // Xem lịch đặt của trainer
    public function bookings()
    {
        $trainer = Trainer::where('user_id', Auth::id())->first();

        if (!$trainer) {
            return redirect()->route('login');
        }

        $bookings = Booking::where('trainer_id', $trainer->id)
            ->where('booking_date', '>=', Carbon::today())
            ->with('member.user')
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->paginate(15);

        return view('trainer.schedule.bookings', [
            'bookings' => $bookings,
            'trainer' => $trainer,
        ]);
    }

    // Nhận lịch (accept booking)
    public function acceptBooking(Booking $booking)
    {
        $trainer = Trainer::where('user_id', Auth::id())->first();

        if (!$trainer) {
            return redirect()->route('login');
        }

        if ($booking->trainer_id !== $trainer->id) {
            return redirect()->back()->with('error', 'Không có quyền thao tác');
        }

        $booking->status = 1; // confirmed
        $booking->save();

        return redirect()->back()->with('success', 'Đã nhận lịch thành công');
    }

    // Hủy lịch (cancel booking)
    public function cancelBooking(Request $request, Booking $booking)
    {
        $trainer = Trainer::where('user_id', Auth::id())->first();

        if (!$trainer) {
            return redirect()->route('login');
        }
        if ($booking->trainer_id !== $trainer->id) {
            return redirect()->back()->with('error', 'Bạn không có quyền thao tác trên lịch hẹn này.');
        }
        if (!$booking->canBeCancelled()) {
            $dateOnly = Carbon::parse($booking->booking_date)->format('Y-m-d');
            $bookingDateTime = Carbon::parse($dateOnly . ' ' . $booking->start_time);
            $hoursUntilBooking = round(now()->diffInHours($bookingDateTime, false));
            $hoursRequired = round($booking->cancellation_hours_before);

            if ($hoursUntilBooking < 0) {
                $errorMessage = "Không thể hủy lịch. Lịch hẹn này đã hoặc đang diễn ra.";
            } else {
                $hoursOverdue = $hoursRequired - $hoursUntilBooking;
                $errorMessage = "Không thể hủy lịch. Quy định phải hủy trước tối thiểu {$hoursRequired} giờ. Hiện tại chỉ còn {$hoursUntilBooking} giờ nữa là đến lịch (Bạn đã quá hạn hủy {$hoursOverdue} giờ).";
            }

            return redirect()->back()->with('error', $errorMessage);
        }
        $booking->status = 0; // cancelled
        $booking->cancelled_at = now();
        $booking->save();

        return redirect()->back()->with('success', 'Đã hủy lịch thành công.');
    }
}
