<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        // Tìm những user có role là member để tạo hồ sơ hội viên
        $users = DB::table('users')->where('role', 'member')->get();

        foreach ($users as $user) {
            DB::table('members')->insert([
                'user_id' => $user->id,
                'gender' => 'male',
                'dob' => '2000-01-01',
                'height' => 170.5,
                'weight' => 65.0,
                'join_date' => Carbon::now()->subDays(rand(1, 20))->format('Y-m-d'), // Tham gia vài ngày trước
                'created_at' => Carbon::now()->subDays(rand(1, 20)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}