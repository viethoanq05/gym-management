<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderByDesc('id')->paginate(15);

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(StorePackageRequest $request)
    {
        try {
            Package::create($request->validated());

            return redirect()->route('admin.packages.index')->with('success', 'Tạo gói tập thành công.');
        } catch (\Exception $e) {
            Log::error('Package store failed: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi xử lý dữ liệu. Vui lòng kiểm tra lại hoặc liên hệ quản trị viên.')->withInput();
        }
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
        try {
            $package->update($request->validated());

            return redirect()->route('admin.packages.index')->with('success', 'Cập nhật gói tập thành công.');
        } catch (\Exception $e) {
            Log::error('Package update failed: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi xử lý dữ liệu. Vui lòng kiểm tra lại hoặc liên hệ quản trị viên.')->withInput();
        }
    }

    public function destroy(Package $package)
    {
        try {
            $package->delete();

            return redirect()->route('admin.packages.index')->with('success', 'Xóa gói tập thành công.');
        } catch (\Exception $e) {
            Log::error('Package delete failed: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi xử lý dữ liệu. Vui lòng kiểm tra lại hoặc liên hệ quản trị viên.');
        }
    }
}
