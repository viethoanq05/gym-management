<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckinSeeder extends Seeder
{
    public function run(): void
    {
        $members = DB::table('members')->get();

        foreach ($members as $member) {
            DB::table('checkins')->insert([
                'member_id' => $member->id,
                // Check-in đúng vào thời điểm ngày hôm nay để Dashboard đếm được
                'check_in_time' => Carbon::today()->addHours(rand(8, 18)), 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}