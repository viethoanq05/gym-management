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
            abort(403, 'Tai khoan khong phai hoi vien.');
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
            abort(403, 'Tai khoan khong phai hoi vien.');
        }

        $hasSchedule = TrainerSchedule::query()
            ->where('trainer_id', $data['trainer_id'])
            ->whereDate('work_date', $data['booking_date'])
            ->where('start_time', '<=', $data['start_time'])
            ->where('end_time', '>=', $data['end_time'])
            ->exists();

        if (! $hasSchedule) {
            return back()->withErrors([
                'booking_date' => 'PT khong co lich lam viec trong khung gio nay.',
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
                'start_time' => 'Khung gio nay da co nguoi dat voi PT.',
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

        return redirect()->route('member.bookings.index')->with('success', 'Dat lich PT thanh cong.');
    }

    public function cancel(int $bookingId): RedirectResponse
    {
        $member = Auth::user()?->member;

        if (! $member) {
            abort(403, 'Tai khoan khong phai hoi vien.');
        }

        $booking = $member->bookings()->findOrFail($bookingId);
        $booking->update(['status' => Booking::CANCELLED]);

        return back()->with('success', 'Da huy lich PT.');
    }
}
