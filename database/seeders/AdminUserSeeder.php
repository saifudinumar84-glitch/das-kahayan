<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat akun Administrator pertama.
 * Isi ADMIN_EMAIL dan ADMIN_PASSWORD di .env, lalu jalankan:
 *   php artisan db:seed --class=AdminUserSeeder
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->error('ADMIN_EMAIL dan ADMIN_PASSWORD belum diisi di .env');

            return;
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $user->name ?: 'Administrator';
        $user->password = Hash::make($password);
        $user->forceFill(['role' => 'admin', 'is_active' => true])->save();

        $this->command?->info("Akun admin siap: {$email}");
    }
}
