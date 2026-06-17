<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::with('member')
            ->where('role', 'member')
            ->latest()
            ->paginate(15);

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Tạo user trước, mã hoá password và gán role = member
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'role' => 'member',
                ]);

                // Tạo record member liên kết 1-1
                $user->member()->create([
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'join_date' => $request->join_date,
                ]);
            });

            return redirect()->route('admin.members.index')->with('success', 'Tạo hội viên thành công.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::with('member')->where('role', 'member')->findOrFail($id);
        return view('admin.members.edit', compact('user'));
    }

    public function update(UpdateMemberRequest $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                // Cập nhật user
                $user = User::where('role', 'member')->findOrFail($id);
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);

                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                }

                // Cập nhật/ tạo thông tin member
                $user->member()->updateOrCreate([], [
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'join_date' => $request->join_date,
                ]);
            });

            return redirect()->route('admin.members.index')->with('success', 'Cập nhật hội viên thành công.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::where('role', 'member')->findOrFail($id);
            // Xoá member và user
            DB::transaction(function () use ($user) {
                $user->member()->delete();
                $user->delete();
            });

            return redirect()->route('admin.members.index')->with('success', 'Xoá hội viên thành công.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
