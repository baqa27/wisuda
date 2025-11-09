<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Wisuda',
            'email' => 'admin@wisuda.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_hp' => '081234567890',
        ]);

        // Create sample mahasiswa
        User::create([
            'name' => 'Muhammad Sultan Baqa',
            'email' => 'sultanbaqa25@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'mahasiswa',
            'nim' => '2023150108',
            'prodi' => 'Teknik Informatika',
            'ipk' => 3.75,
            'no_hp' => '081234567891',
        ]);

        User::create([
            'name' => 'Siti Rahma',
            'email' => 'siti@wisuda.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'nim' => '210201002',
            'prodi' => 'Sistem Informasi',
            'ipk' => 3.80,
            'no_hp' => '081234567892',
        ]);
    }
}
