<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trainer;
use App\Models\TrainerSchedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberBookingController extends Controller
{
    public function index(): View
    {
        $member = Auth::user()?->member;

        if (! $member) {
            abort(403, 'Tài khoản không phải hội viên.');
        }

        $bookings = $member->bookings()
            ->with('trainer.user')
            ->orderByDesc('booking_date')
            ->orderByDesc('start_time')
            ->get();

        return view('member.bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        $trainers = Trainer::query()->with('user')->get();

        return view('member.bookings.create', compact('trainers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'trainer_id' => ['required', 'integer', 'exists:trainers,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $member = Auth::user()?->member;

        if (! $member) {
            abort(403, 'Tài khoản không phải hội viên.');
        }

        $hasSchedule = TrainerSchedule::query()
            ->where('trainer_id', $data['trainer_id'])
            ->whereDate('work_date', $data['booking_date'])
            ->where('start_time', '<=', $data['start_time'])
            ->where('end_time', '>=', $data['end_time'])
            ->exists();

        if (! $hasSchedule) {
            return back()->withErrors([
                'booking_date' => 'PT không có lịch làm việc trong khung giờ này.',
            ])->withInput();
        }

        $trainerOverlap = Booking::query()
            ->where('trainer_id', $data['trainer_id'])
            ->whereDate('booking_date', $data['booking_date'])
            ->whereIn('status', [Booking::PENDING, Booking::CONFIRMED])
            ->where(function ($query) use ($data): void {
                $query->where('start_time', '<', $data['end_time'])
                    ->where('end_time', '>', $data['start_time']);
            })
            ->exists();

        if ($trainerOverlap) {
            return back()->withErrors([
                'start_time' => 'Khung giờ này đã có người đặt với PT.',
            ])->withInput();
        }

        Booking::create([
            'member_id' => $member->id,
            'trainer_id' => $data['trainer_id'],
            'booking_date' => $data['booking_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'status' => Booking::PENDING,
        ]);

        return redirect()->route('member.bookings.index')->with('success', 'Đặt lịch PT thành công.');
    }

    public function cancel(int $bookingId): RedirectResponse
    {
        $member = Auth::user()?->member;

        if (! $member) {
            abort(403, 'Tài khoản không phải hội viên.');
        }

        $booking = $member->bookings()->findOrFail($bookingId);
        $booking->update(['status' => Booking::CANCELLED]);

        return back()->with('success', 'Đã hủy lịch PT.');
    }

    /**
     * API: Trả về lịch làm việc + booking đã đặt của PT trong 1 ngày.
     */
    public function getTrainerAvailability(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'trainer_id' => ['required', 'integer', 'exists:trainers,id'],
            'date' => ['required', 'date'],
        ]);

        $trainerId = $request->input('trainer_id');
        $date = $request->input('date');

        // Lịch làm việc của PT trong ngày
        $schedules = TrainerSchedule::query()
            ->where('trainer_id', $trainerId)
            ->whereDate('work_date', $date)
            ->orderBy('start_time')
            ->get(['start_time', 'end_time']);

        // Các booking đã đặt (pending / confirmed) trong ngày
        $bookedSlots = Booking::query()
            ->where('trainer_id', $trainerId)
            ->whereDate('booking_date', $date)
            ->whereIn('status', [Booking::PENDING, Booking::CONFIRMED])
            ->orderBy('start_time')
            ->get(['start_time', 'end_time', 'status']);

        return response()->json([
            'schedules' => $schedules->map(fn ($s) => [
                'start' => substr($s->start_time, 0, 5),
                'end' => substr($s->end_time, 0, 5),
            ]),
            'booked' => $bookedSlots->map(fn ($b) => [
                'start' => substr($b->start_time, 0, 5),
                'end' => substr($b->end_time, 0, 5),
                'status' => $b->status === Booking::PENDING ? 'pending' : 'confirmed',
            ]),
        ]);
    }
}
