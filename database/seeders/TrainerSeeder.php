<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainerSeeder extends Seeder
{
    public function run(): void
    {
        $trainerUsers = DB::table('users')
            ->where('role', 'trainer')
            ->orderBy('id')
            ->get(['id'])
            ->all();

        if (empty($trainerUsers)) {
            return;
        }

        $trainers = [
            [
                'description' => 'Huấn luyện viên thể hình chuyên về giảm mỡ và tăng cơ.',
                'specialization' => 'Fitness & Weight Loss',
                'experience_years' => 5,
            ],
            [
                'description' => 'Huấn luyện viên boxing và cardio cường độ cao.',
                'specialization' => 'Boxing & HIIT',
                'experience_years' => 4,
            ],
        ];

        foreach ($trainerUsers as $index => $trainerUser) {
            $profile = $trainers[$index % count($trainers)];

            DB::table('trainers')->updateOrInsert(
                ['user_id' => $trainerUser->id],
                [
                    'description' => $profile['description'],
                    'specialization' => $profile['specialization'],
                    'experience_years' => $profile['experience_years'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
