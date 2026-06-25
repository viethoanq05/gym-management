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
            ->paginate(15);

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
            return redirect()->back()->with('error', 'Không có quyền thao tác');
        }

        // Kiểm tra xem có thể hủy lịch hay không
        if (!$booking->canBeCancelled()) {
            $bookingDateTime = Carbon::parse($booking->booking_date . ' ' . $booking->start_time);
            $hoursUntilBooking = now()->diffInHours($bookingDateTime, false);
            $hoursRequired = $booking->cancellation_hours_before;
            $hoursNeeded = $hoursRequired - $hoursUntilBooking;
            return redirect()->back()->with('error', "Không thể hủy lịch. Phải hủy trước tối thiểu {$hoursRequired} giờ. Còn {$hoursUntilBooking} giờ nữa, cần chờ thêm {$hoursNeeded} giờ");
        }

        $booking->status = 0; // cancelled
        $booking->cancelled_at = now();
        $booking->save();

        return redirect()->back()->with('success', 'Đã hủy lịch thành công');
    }
}
