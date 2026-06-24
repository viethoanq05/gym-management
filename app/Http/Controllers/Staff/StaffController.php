<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\CheckIn;
use App\Models\Booking;
use App\Models\Membership;
use App\Models\User;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function createMember()
    {
        return view('staff.members.create');
    }

    public function storeMember(Request $request)
    {
        $request->validate([
            //User account
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone', 
            'password' => 'required|min:6',
            
            //Member table
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'join_date' => 'required|date',
        ], [
            'email.unique' => 'Email này đã tồn tại trong hệ thống.',
            'phone.unique' => 'Số điện thoại này đã được đăng ký.'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone, 
                'password' => Hash::make($request->password),
                'role' => 'member', 
            ]);

            Member::create([
                'user_id' => $user->id,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'height' => $request->height,
                'weight' => $request->weight,
                'join_date' => $request->join_date,
            ]);

            DB::commit();
            
            return redirect()->route('staff.dashboard')->with('success', 'Đã thêm hồ sơ hội viên mới thành công!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }
}
