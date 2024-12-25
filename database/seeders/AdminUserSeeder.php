<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User:: create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash:: make('password'), // Sử dụng mật khẩu mặc định
        'role' => 'admin',
        ]);
    }
}
