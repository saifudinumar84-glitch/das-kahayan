<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed user accounts for all roles in Si Kahayan.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            // Administrator
            [
                'name' => 'Umar Saifudin',
                'email' => 'saifudinumar@gmail.com',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'is_active' => true,
            ],
            // Ketua Tim
            [
                'name' => 'Dwi Rahmawati',
                'email' => 'dwi.rahmawati@pom.go.id',
                'phone' => '081298765432',
                'password' => Hash::make('password'),
                'role' => UserRole::TeamLeader,
                'is_active' => true,
            ],
            // Kepala Balai
            [
                'name' => 'Dr. Ahmad Fauzi, Apt.',
                'email' => 'kepala@bbpom-palangkaraya.go.id',
                'phone' => '081311223344',
                'password' => Hash::make('password'),
                'role' => UserRole::Head,
                'is_active' => true,
            ],
            // Petugas Layanan / Inspektur 1
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@pom.go.id',
                'phone' => '081244556677',
                'password' => Hash::make('password'),
                'role' => UserRole::Inspector,
                'is_active' => true,
            ],
            // Petugas Layanan / Inspektur 2
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@pom.go.id',
                'phone' => '081355667788',
                'password' => Hash::make('password'),
                'role' => UserRole::Inspector,
                'is_active' => true,
            ],
            // Petugas Layanan / Inspektur 3
            [
                'name' => 'Rini Susanti',
                'email' => 'rini.susanti@pom.go.id',
                'phone' => '081266778899',
                'password' => Hash::make('password'),
                'role' => UserRole::Inspector,
                'is_active' => true,
            ],
            // Pelaku Usaha 1
            [
                'name' => 'Hendra Wijaya',
                'email' => 'hendra@cvkahayanjaya.com',
                'phone' => '081377889900',
                'password' => Hash::make('password'),
                'role' => UserRole::Business,
                'is_active' => true,
            ],
            // Pelaku Usaha 2
            [
                'name' => 'Slamet Riyadi',
                'email' => 'slamet@ud-katingan.com',
                'phone' => '081488990011',
                'password' => Hash::make('password'),
                'role' => UserRole::Business,
                'is_active' => true,
            ],
            // Pelaku Usaha 3
            [
                'name' => 'Yuliana Putri',
                'email' => 'yuliana@pt-kahayan.com',
                'phone' => '081599001122',
                'password' => Hash::make('password'),
                'role' => UserRole::Business,
                'is_active' => true,
            ],
            // Pelaku Usaha 4 — Distributor
            [
                'name' => 'Agus Prabowo',
                'email' => 'agus@distributor-palangka.com',
                'phone' => '081600112233',
                'password' => Hash::make('password'),
                'role' => UserRole::Business,
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }
    }
}
