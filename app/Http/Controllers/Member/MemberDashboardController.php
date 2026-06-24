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
            abort(403, 'Tài khoản không phải hội viên.');
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

        // Monthly check-in count
        $now = now();
        $monthlyCheckinCount = \Illuminate\Support\Facades\DB::table('checkins')
            ->where('member_id', $member->id)
            ->whereBetween('checkin_time', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->count();

        $recentCheckins = \Illuminate\Support\Facades\DB::table('checkins')
            ->where('member_id', $member->id)
            ->orderByDesc('checkin_time')
            ->take(3)
            ->get();

        return view('member.dashboard', [
            'member' => $member,
            'activeMembership' => $activeMembership,
            'upcomingBookings' => $upcomingBookings,
            'monthlyCheckinCount' => $monthlyCheckinCount,
            'recentCheckins' => $recentCheckins,
        ]);
    }
}
