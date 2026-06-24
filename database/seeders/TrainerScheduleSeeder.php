<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrainerScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $trainers = DB::table('trainers')->pluck('id')->all();

        if (empty($trainers)) {
            return;
        }

        $today = Carbon::today();
        $records = [];

        // Tạo lịch làm việc cho 14 ngày tới
        for ($day = 0; $day < 14; $day++) {
            $date = $today->copy()->addDays($day);

            // Bỏ qua Chủ Nhật
            if ($date->isSunday()) {
                continue;
            }

            foreach ($trainers as $trainerId) {
                // Ca sáng: 08:00 - 12:00
                $records[] = [
                    'trainer_id' => $trainerId,
                    'work_date' => $date->toDateString(),
                    'start_time' => '08:00:00',
                    'end_time' => '12:00:00',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Ca chiều: 14:00 - 18:00 (bỏ thứ 7 chiều)
                if (! $date->isSaturday()) {
                    $records[] = [
                        'trainer_id' => $trainerId,
                        'work_date' => $date->toDateString(),
                        'start_time' => '14:00:00',
                        'end_time' => '18:00:00',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Ca tối: 19:00 - 21:00
                    $records[] = [
                        'trainer_id' => $trainerId,
                        'work_date' => $date->toDateString(),
                        'start_time' => '19:00:00',
                        'end_time' => '21:00:00',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Xóa dữ liệu cũ rồi insert mới
        DB::table('trainer_schedules')->truncate();
        DB::table('trainer_schedules')->insert($records);
    }
}
