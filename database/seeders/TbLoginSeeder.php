<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TbLoginSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_login')->updateOrInsert(
            ['email' => 'admin1@gmail.com'],
            [
                'nama' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
