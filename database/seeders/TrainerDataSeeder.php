<?php

namespace Database\Seeders;

use App\Models\Trainer;
use App\Models\Member;
use App\Models\Booking;
use App\Models\CheckIn;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TrainerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy một số trainer và member đã tồn tại
        $trainers = Trainer::take(3)->get();
        $members = Member::take(5)->get();

        if ($trainers->isEmpty() || $members->isEmpty()) {
            $this->command->info('Cần phải có trainer và member được tạo trước!');
            return;
        }

        // Tạo Bookings
        $now = Carbon::now();
        foreach ($trainers as $trainer) {
            foreach ($members as $member) {
                // Lịch trong quá khứ (đã hoàn thành)
                Booking::create([
                    'member_id' => $member->id,
                    'trainer_id' => $trainer->id,
                    'booking_date' => $now->clone()->subDays(10),
                    'start_time' => '09:00:00',
                    'end_time' => '10:30:00',
                    'status' => 1, // Confirmed
                    'cancellation_hours_before' => 24,
                ]);

                // Lịch trong tương lai (sắp tới)
                Booking::create([
                    'member_id' => $member->id,
                    'trainer_id' => $trainer->id,
                    'booking_date' => $now->clone()->addDays(3),
                    'start_time' => '14:00:00',
                    'end_time' => '15:30:00',
                    'status' => 2, // Pending
                    'cancellation_hours_before' => 24,
                ]);

                // Lịch trong tương lai (sau đó)
                Booking::create([
                    'member_id' => $member->id,
                    'trainer_id' => $trainer->id,
                    'booking_date' => $now->clone()->addDays(7),
                    'start_time' => '10:00:00',
                    'end_time' => '11:30:00',
                    'status' => 1, // Confirmed
                    'cancellation_hours_before' => 24,
                ]);
            }
        }

        // Tạo CheckIns
        foreach ($members as $member) {
            for ($i = 0; $i < 5; $i++) {
                CheckIn::create([
                    'member_id' => $member->id,
                    'checkin_time' => $now->clone()->subDays($i)->setHour(7)->setMinute(0),
                    'checkout_time' => $now->clone()->subDays($i)->setHour(9)->setMinute(30),
                ]);
            }
        }

        $this->command->info('Trainer data seeded successfully!');
    }
}
