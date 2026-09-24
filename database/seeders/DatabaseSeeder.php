<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'saifudinumar@gmail.com'],
            [
                'name' => 'Umar Saifudin',
                'password' => bcrypt('password'),
                'role' => UserRole::Admin,
                'is_active' => true,
            ]
        );
    }
}
