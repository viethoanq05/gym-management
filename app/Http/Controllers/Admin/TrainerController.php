<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrainerRequest;
use App\Http\Requests\UpdateTrainerRequest;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = User::with('trainer')->where('role', 'trainer')->latest()->paginate(15);
        return view('admin.trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('admin.trainers.create');
    }

    public function store(StoreTrainerRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'role' => 'trainer',
                ]);

                $user->trainer()->create([
                    'description' => $request->description,
                    'specialization' => $request->specialization,
                    'experience_years' => $request->experience_years,
                ]);
            });

            return redirect()->route('admin.trainers.index')->with('success', 'Tạo trainer thành công.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::with('trainer')->where('role', 'trainer')->findOrFail($id);
        return view('admin.trainers.edit', compact('user'));
    }

    public function update(UpdateTrainerRequest $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $user = User::where('role', 'trainer')->findOrFail($id);
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);

                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                }

                $user->trainer()->updateOrCreate([], [
                    'description' => $request->description,
                    'specialization' => $request->specialization,
                    'experience_years' => $request->experience_years,
                ]);
            });

            return redirect()->route('admin.trainers.index')->with('success', 'Cập nhật trainer thành công.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::where('role', 'trainer')->findOrFail($id);
            DB::transaction(function () use ($user) {
                $user->trainer()->delete();
                $user->delete();
            });

            return redirect()->route('admin.trainers.index')->with('success', 'Xoá trainer thành công.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
