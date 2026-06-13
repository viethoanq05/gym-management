<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\CheckIn;

class StaffController extends Controller
{
    // Renders the initial check-in form
    public function showCheckIn()
    {
        return view('staff.checkin');
    }

    // Handles the search form submission
    public function searchMember(Request $request)
    {
        $query = $request->input('search');

        // Search the members table by digging into its related 'user' record
        $members = Member::whereHas('user', function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%");
        })->get();

        return view('staff.checkin', compact('members', 'query'));
    }

    public function storeCheckIn($id)
    {
        // Find the member record
        $member = Member::findOrFail($id);

        // Create the check-in record using your existing migration structure
        CheckIn::create([
            'member_id'    => $member->id,
            'checkin_time' => now(), // 👈 Automatically logs the current date & time
        ]);

        // Redirect back with a clean flash alert
        return redirect()
            ->route('staff.checkin')
            ->with('success', "Đã duyệt hội viên {$member->user->name} vào phòng tập thành công!");
    }
}
