<?php

namespace App\View\Composers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MemberNotificationComposer
{
    public function compose(View $view): void
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'member' || ! $user->member) {
            $view->with('upcomingNotifications', collect());
            return;
        }

        $member = $user->member;

        $upcomingNotifications = $member->bookings()
            ->with('trainer.user')
            ->whereIn('status', [Booking::PENDING, Booking::CONFIRMED])
            ->whereDate('booking_date', '>=', now()->toDateString())
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->take(10)
            ->get();

        $view->with('upcomingNotifications', $upcomingNotifications);
    }
}
