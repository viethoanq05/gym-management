<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Member;
use App\Models\Trainer;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['member.user', 'trainer.user'])
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $members = Member::with('user')->get();
        $trainers = Trainer::with('user')->get();

        return view('admin.bookings.create', compact('members', 'trainers'));
    }

    public function store(StoreBookingRequest $request)
    {
        try {
            Booking::create($request->validated());

            return redirect()->route('admin.bookings.index')->with('success', 'Tạo đặt lịch thành công.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit(Booking $booking)
    {
        $members = Member::with('user')->get();
        $trainers = Trainer::with('user')->get();

        return view('admin.bookings.edit', compact('booking', 'members', 'trainers'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        try {
            $booking->update($request->validated());

            return redirect()->route('admin.bookings.index')->with('success', 'Cập nhật lịch đặt thành công.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();

            return redirect()->route('admin.bookings.index')->with('success', 'Xóa lịch đặt thành công.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
