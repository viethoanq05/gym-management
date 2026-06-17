<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Member;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Membership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['membership.member.user', 'membership.package'])
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $members = Member::with('user')
            ->whereHas('user', fn($query) => $query->where('role', 'member'))
            ->get();

        $packages = Package::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.payments.create', compact('members', 'packages'));
    }

    public function store(StorePaymentRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();
                $package = Package::findOrFail($validated['package_id']);

                $startDate = Carbon::parse($validated['payment_date'])->toDateString();
                $endDate = Carbon::parse($startDate)
                    ->addDays($package->duration_days)
                    ->toDateString();

                $membership = Membership::create([
                    'member_id' => $validated['member_id'],
                    'package_id' => $validated['package_id'],
                    'package_price' => $package->price,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 1,
                ]);

                Payment::create([
                    'membership_id' => $membership->id,
                    'amount' => $validated['amount'],
                    'payment_method' => $validated['payment_method'],
                    'payment_date' => $validated['payment_date'],
                    'status' => 1,
                ]);
            });

            return redirect()->route('admin.payments.index')->with('success', 'Tạo giao dịch thành công.');
        } catch (\Exception $e) {
            Log::error('Payment store failed: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());

            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        try {
            $payment->delete();

            return redirect()->route('admin.payments.index')->with('success', 'Xóa giao dịch thành công.');
        } catch (\Exception $e) {
            Log::error('Payment delete failed: ' . $e->getMessage());

            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi xử lý dữ liệu. Vui lòng kiểm tra lại hoặc liên hệ quản trị viên.');
        }
    }
}
