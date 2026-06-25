<?php

namespace App\Http\Controllers\Trainer;

use App\Models\Trainer;
use App\Models\Member;
use App\Models\CheckIn;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberStatusController extends Controller
{
    // Xem danh sách hội viên
    public function index()
    {
        $trainer = Trainer::where('user_id', Auth::id())->first();

        if (!$trainer) {
            return redirect()->route('login');
        }

        // Lấy danh sách hội viên mà trainer đã làm việc
        $memberIds = $trainer->bookings()
            ->whereIn('status', [1, 3]) // confirmed or completed bookings
            ->distinct()
            ->pluck('member_id');

        $members = Member::whereIn('id', $memberIds)
            ->with('user')
            ->paginate(15);

        return view('trainer.members.index', [
            'members' => $members,
            'trainer' => $trainer,
        ]);
    }

    // Xem chi tiết thể trạng hội viên
    public function show(Member $member)
    {
        $trainer = Trainer::where('user_id', Auth::id())->first();

        if (!$trainer) {
            return redirect()->route('login');
        }

        // Kiểm tra xem trainer có công việc với hội viên này không
        $hasBooking = $trainer->bookings()
            ->where('member_id', $member->id)
            ->whereIn('status', [1, 3])
            ->exists();

        if (!$hasBooking) {
            return redirect()->back()->with('error', 'Bạn không có quyền xem thông tin hội viên này');
        }

        // Lấy check-in history
        $checkinHistory = CheckIn::where('member_id', $member->id)
            ->orderBy('checkin_time', 'desc')
            ->paginate(20);

        // Tính toán chỉ số
        $bmi = $this->calculateBMI($member->height, $member->weight);
        $lastCheckIn = CheckIn::where('member_id', $member->id)
            ->latest('checkin_time')
            ->first();

        $currentMonth = Carbon::now()->startOfMonth();
        $checkinsThisMonth = CheckIn::where('member_id', $member->id)
            ->where('checkin_time', '>=', $currentMonth)
            ->count();

        return view('trainer.members.show', [
            'member' => $member,
            'checkinHistory' => $checkinHistory,
            'bmi' => $bmi,
            'lastCheckIn' => $lastCheckIn,
            'checkinsThisMonth' => $checkinsThisMonth,
            'trainer' => $trainer,
        ]);
    }

    private function calculateBMI($height, $weight): float
    {
        if ($height <= 0) {
            return 0;
        }
        // height in cm, convert to m
        $heightM = $height / 100;
        return round($weight / ($heightM * $heightM), 2);
    }

    // Thêm ghi chú theo dõi (nếu cần)
    public function addNote(Request $request, Member $member)
    {
        $trainer = Trainer::where('user_id', Auth::id())->first();

        if (!$trainer) {
            return redirect()->route('login');
        }

        // Kiểm tra xem trainer có công việc với hội viên này không
        $hasBooking = $trainer->bookings()
            ->where('member_id', $member->id)
            ->whereIn('status', [1, 3])
            ->exists();

        if (!$hasBooking) {
            return redirect()->back()->with('error', 'Bạn không có quyền ghi chú cho hội viên này');
        }

        $request->validate([
            'note' => 'required|string|max:500',
        ]);

        // TODO: Tạo bảng TrainerNote để lưu ghi chú
        // TrainerNote::create([
        //     'trainer_id' => $trainer->id,
        //     'member_id' => $member->id,
        //     'note' => $request->note,
        // ]);

        return redirect()->back()->with('success', 'Đã thêm ghi chú thành công');
    }
}
