<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        $packages = DB::table('packages')->get(['id', 'price', 'duration_days'])->toArray();
        $memberUsers = DB::table('users')->where('role', 'member')->get(['id'])->toArray();

        if (empty($packages) || empty($memberUsers)) {
            return;
        }

        $now = now();

        $memberIds = [];

        foreach ($memberUsers as $index => $memberUser) {
            $exists = DB::table('members')->where('user_id', $memberUser->id)->value('id');

            if ($exists) {
                $memberIds[] = $exists;
                continue;
            }

            $memberIds[] = DB::table('members')->insertGetId([
                'user_id' => $memberUser->id,
                'gender' => $index % 2 === 0 ? 'male' : 'female',
                'dob' => Carbon::now()->subYears(20 + $index)->toDateString(),
                'height' => 168.00 + $index,
                'weight' => 62.00 + $index,
                'join_date' => $now->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($memberIds as $i => $memberId) {
            $package = $packages[$i % count($packages)];
            $startDate = $now->copy()->subDays($i * 7);
            $endDate = $startDate->copy()->addDays($package->duration_days);

            DB::table('memberships')->insert([
                'member_id' => $memberId,
                'package_id' => $package->id,
                'package_price' => $package->price,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
