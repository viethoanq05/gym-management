<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Membership;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    public function index(): View
    {
        $member = Auth::user()?->member;

        if (! $member) {
            abort(403, 'Tai khoan khong phai hoi vien.');
        }

        $activeMembership = $member->memberships()
            ->with('package')
            ->where('status', Membership::ACTIVE)
            ->latest('id')
            ->first();

        $upcomingBookings = $member->bookings()
            ->with('trainer.user')
            ->whereIn('status', [Booking::PENDING, Booking::CONFIRMED])
            ->whereDate('booking_date', '>=', now()->toDateString())
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        $targetWeight = round(($member->gender === 'male' ? ($member->height - 100) * 0.9 : ($member->height - 100) * 0.85), 1);

        $recentCheckins = \Illuminate\Support\Facades\DB::table('checkins')
            ->where('member_id', $member->id)
            ->orderByDesc('checkin_time')
            ->take(3)
            ->get();

        return view('member.dashboard', [
            'member' => $member,
            'activeMembership' => $activeMembership,
            'upcomingBookings' => $upcomingBookings,
            'targetWeight' => $targetWeight,
            'recentCheckins' => $recentCheckins,
        ]);
    }
}


