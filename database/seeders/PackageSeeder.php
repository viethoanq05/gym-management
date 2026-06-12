<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            ['name' => 'Cơ Bản', 'price' => 500000, 'duration_days' => 30, 'description' => 'Gói cơ bản với quyền truy cập vào phòng tập và các thiết bị cơ bản.', 'status' => 1],
            ['name' => 'Nâng Cao', 'price' => 800000, 'duration_days' => 30, 'description' => 'Gói nâng cao với quyền truy cập vào phòng tập và các thiết bị chuyên dụng.', 'status' => 1],
            ['name' => 'Premium', 'price' => 1200000, 'duration_days' => 30, 'description' => 'Gói premium với tất cả các tiện ích và dịch vụ cao cấp.', 'status' => 1],
        ];

        foreach ($packages as $p) {
            DB::table('packages')->insert(array_merge($p, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
