<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create specific users
        DB::table('users')->insert(
            [
                [
                    'name' => 'Admin User',
                    'email' => 'admin@ironcore.test',
                    'phone' => '0123456789',
                    'role' => 'admin',
                    'password' => Hash::make('admin1234'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Vinh Trainer',
                    'email' => 'vinhtrainer@ironcore.test',
                    'role' => 'trainer',
                    'phone' => '0987654320',
                    'password' => Hash::make('vinh1234'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Tuấn Trainer',
                    'email' => 'tuantrainer@ironcore.test',
                    'role' => 'trainer',
                    'phone' => '0987654321',
                    'password' => Hash::make('tuan1234'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Hùng Staff',
                    'email' => 'staff@ironcore.test',
                    'role' => 'staff',
                    'phone' => '0912345678',
                    'password' => Hash::make('hung1234'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Đắc Đại',
                    'email' => 'daitruong@ironcore.test',
                    'role' => 'member',
                    'phone' => '0900000001',
                    'password' => Hash::make('daitr1234'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Văn Tuyên',
                    'email' => 'tuyen@ironcore.test',
                    'role' => 'member',
                    'phone' => '0900000002',
                    'password' => Hash::make('vantuyen1234'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        );
    }
}
