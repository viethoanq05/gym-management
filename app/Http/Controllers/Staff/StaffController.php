<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\CheckIn;
use App\Models\Booking;
use App\Models\Membership;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function showCheckIn()
    {
        return view('staff.checkin');
    }

    public function searchMember(Request $request)
    {
        $query = $request->input('search');
        
        $members = Member::whereHas('user', function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%");
        })->get();

        $activeCheckinIds = DB::table('checkins') 
            ->whereDate('checkin_time', Carbon::today())
            ->whereNull('checkout_time')
            ->pluck('member_id')
            ->toArray();

        return view('staff.checkin', compact('members', 'query', 'activeCheckinIds'));
    }

    public function checkoutMember($id)
    {
        DB::table('checkins')
            ->where('member_id', $id)
            ->whereNull('checkout_time')
            ->update([
                'checkout_time' => Carbon::now()
            ]);

        return redirect()->route('staff.checkin')->with('success', 'Hội viên đã check-out và rời phòng tập!');
    }

    public function storeCheckIn($id)
    {
        $member = Member::findOrFail($id);

        CheckIn::create([
            'member_id'    => $member->id,
            'checkin_time' => now(),
        ]);

        return redirect()->route('staff.checkin')->with('success', 'Đã xác nhận hội viên vào phòng tập!');
    }

    public function showSchedules()
    {
        $bookings = Booking::with(['member.user'])->orderBy('booking_date', 'asc')->get();

        return view('staff.schedules', compact('bookings'));
    }

    public function confirmSchedule($id)
    {
        $booking = Booking::findOrFail($id);
        
        $booking->update([
            'status' => 1 
        ]);

        return redirect()->back()->with('success', 'Đã xác nhận lịch tập của hội viên thành công!');
    }

    public function showMemberships()
    {
        $memberships = Membership::with(['member.user'])->orderBy('created_at', 'desc')->get();
        return view('staff.memberships', compact('memberships'));
    }

    public function confirmMembership($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->update(['status' => 1]);

        return redirect()->back()->with('success', 'Đã kích hoạt gói tập cho hội viên thành công!');
    }

    public function rejectMembership($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->update(['status' => 4]);

        return redirect()->back()->with('success', 'Đã từ chối yêu cầu đăng ký gói tập thành công!');
    }

    public function freezeMembership($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->update(['status' => 2]);

        return redirect()->back()->with('success', 'Đã tạm hoãn gói tập của hội viên thành công!');
    }

    public function unfreezeMembership($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->update(['status' => 1]);

        return redirect()->back()->with('success', 'Đã kích hoạt lại gói tập cho hội viên thành công!');
    }

    public function cancelMembership($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->update(['status' => 3]);

        return redirect()->back()->with('success', 'Đã hủy bỏ hoàn toàn gói tập thành công!');
    }
}
