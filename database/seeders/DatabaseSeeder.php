<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PackageSeeder;
use Database\Seeders\MembershipSeeder;
use Database\Seeders\TrainerSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TrainerSeeder::class,
            PackageSeeder::class,
            MembershipSeeder::class,
            TrainerScheduleSeeder::class,
            MembershipSeeder::class,
            PaymentSeeder::class,
            CheckinSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
