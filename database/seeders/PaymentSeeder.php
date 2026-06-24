<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy đại 1 gói tập từ MembershipSeeder bạn đã có
        $membership = DB::table('memberships')->first();

        if ($membership) {
            DB::table('payments')->insert([
                [
                    'membership_id' => $membership->id,
                    'amount' => 5000000, // 5 Triệu VNĐ
                    'payment_method' => 1,
                    'payment_date' => Carbon::now()->subDays(2),
                    'status' => 1, // 1 = Hoàn thành
                    'note' => 'Đóng tiền gói 1 năm',
                    'created_at' => Carbon::now()->subDays(2),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'membership_id' => $membership->id,
                    'amount' => 1500000, // 1.5 Triệu VNĐ
                    'payment_method' => 2,
                    'payment_date' => Carbon::now(), // Doanh thu phát sinh hôm nay
                    'status' => 1,
                    'note' => 'Gia hạn gói tập',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            ]);
        }
    }
}