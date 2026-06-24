<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberMembershipController extends Controller
{
    public function packages(): View
    {
        $packages = Package::query()
            ->where('status', 1)
            ->orderBy('price')
            ->get();

        $member = Auth::user()?->member;

        $activeMembership = null;
        $memberships = collect();

        if ($member) {
            $activeMembership = $member->memberships()
                ->with('package')
                ->where('status', Membership::ACTIVE)
                ->latest('id')
                ->first();

            $memberships = $member->memberships()
                ->with('package')
                ->latest('id')
                ->get();
        }

        return view('member.packages', compact('packages', 'activeMembership', 'memberships'));
    }

    public function history(): View
    {
        $member = Auth::user()?->member;

        if (! $member) {
            abort(403, 'Tài khoản không phải hội viên.');
        }

        $memberships = $member->memberships()
            ->with('package')
            ->latest('id')
            ->get();

        return view('member.history', compact('memberships'));
    }

    public function subscribe(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'package_id' => ['required', 'integer', 'exists:packages,id'],
        ]);

        $member = Auth::user()?->member;

        if (! $member) {
            abort(403, 'Tài khoản không phải hội viên.');
        }

        $package = Package::query()
            ->where('status', 1)
            ->findOrFail($data['package_id']);

        Membership::create([
            'member_id' => $member->id,
            'package_id' => $package->id,
            'package_price' => $package->price,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays((int) $package->duration_days)->toDateString(),
            'status' => Membership::WAITING_PAYMENT,
        ]);

        return back()->with('success', 'Đăng ký gói tập thành công.');
    }

    public function cancel(int $membershipId): RedirectResponse
    {
        $member = Auth::user()?->member;

        if (! $member) {
            abort(403, 'Tài khoản không phải hội viên.');
        }

        $membership = $member->memberships()->findOrFail($membershipId);
        $membership->update(['status' => Membership::CANCELLED]);

        return back()->with('success', 'Đã hủy gói tập.');
    }
}
