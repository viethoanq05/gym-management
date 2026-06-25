<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $member = DB::table('members')->first();
        $trainer = DB::table('trainers')->first();

        if ($member && $trainer) {
            DB::table('bookings')->insert([
                [
                    'member_id' => $member->id,
                    'trainer_id' => $trainer->id,
                    'booking_date' => Carbon::today(),
                    'start_time' => '18:00:00',
                    'end_time' => '19:00:00',
                    'status' => 1, // 1 = confirmed
                    'created_at' => Carbon::now()->subMinutes(15), // Mới đặt 15 phút trước
                    'updated_at' => Carbon::now(),
                ],
                [
                    'member_id' => $member->id,
                    'trainer_id' => $trainer->id,
                    'booking_date' => Carbon::tomorrow(),
                    'start_time' => '06:00:00',
                    'end_time' => '07:30:00',
                    'status' => 2, // 2 = pending
                    'created_at' => Carbon::now()->subHours(2), // Đặt từ 2 tiếng trước
                    'updated_at' => Carbon::now(),
                ]
            ]);
        }
    }
}