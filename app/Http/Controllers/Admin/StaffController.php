<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::where('role', 'staff')->latest()->paginate(15);
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(StoreStaffRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'staff',
            ]);

            return redirect()->route('admin.staff.index')->with('success', 'Tạo nhân viên thành công.');
        } catch (\Exception $e) {
            Log::error('Staff store failed: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi xử lý dữ liệu. Vui lòng kiểm tra lại hoặc liên hệ quản trị viên.')->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::where('role', 'staff')->findOrFail($id);
        return view('admin.staff.edit', compact('user'));
    }

    public function update(UpdateStaffRequest $request, $id)
    {
        try {
            $user = User::where('role', 'staff')->findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            return redirect()->route('admin.staff.index')->with('success', 'Cập nhật nhân viên thành công.');
        } catch (\Exception $e) {
            Log::error('Staff update failed: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi xử lý dữ liệu. Vui lòng kiểm tra lại hoặc liên hệ quản trị viên.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::where('role', 'staff')->findOrFail($id);
            $user->delete();
            return redirect()->route('admin.staff.index')->with('success', 'Xoá nhân viên thành công.');
        } catch (\Exception $e) {
            Log::error('Staff delete failed: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi xử lý dữ liệu. Vui lòng kiểm tra lại hoặc liên hệ quản trị viên.');
        }
    }
}
