<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- Import model User
use Illuminate\Support\Facades\Hash; // <-- Import Hash facade

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data user lama jika ada, untuk menghindari duplikat saat seeder dijalankan lagi
        User::truncate();

        // Buat user Guru
        User::create([
            'name' => 'Budi Guru',
            'email' => 'guru@sekolah.com',
            'role' => 'guru',
            'password' => Hash::make(' '), // Password di-hash dengan aman
        ]);

        // Buat user Kepala Sekolah
        User::create([
            'name' => 'Siti Kepala Sekolah',
            'email' => 'kepsek@sekolah.com', 
            'role' => 'kepala_sekolah',
            'password' => Hash::make('password'), // Password di-hash dengan aman
        ]);
    }
}