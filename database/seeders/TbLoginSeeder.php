<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TbLoginSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah user sudah ada
        $existingUser = DB::table('tb_login')->where('email', 'admin1@gmail.com')->first();

        if (!$existingUser) {
            DB::table('tb_login')->insert([
                'nama' => 'Admin',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->command->info('User admin berhasil ditambahkan!');
        } else {
            $this->command->info('User admin sudah ada, skip insert.');
        }
    }
}
