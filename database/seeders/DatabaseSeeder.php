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
        $this->call([
            // 1. Master Users (semua peran)
            UserSeeder::class,

            // 2. Data Master Pangan
            FoodCategorySeeder::class,   // food_categories + food_types
            TestParameterSeeder::class,  // test_parameters

            // 3. Data Master Persyaratan Inspeksi
            InspectionRequirementSeeder::class,  // inspection_requirements (CPPOB & CPerPOB)

            // 4. Sarana Produksi & Distribusi (terhubung ke pelaku usaha)
            FacilitySeeder::class,

            // 5. Alur Pengawasan Layanan A: Sampling & Pengujian
            SamplingSeeder::class,

            // 6. Alur Pengawasan Layanan B: Inspeksi, BAP, CAPA, Closed CAPA
            InspectionSeeder::class,
        ]);

        $this->command->info('✅ Si Kahayan database seeded successfully!');
        $this->command->newLine();
        $this->command->table(
            ['Peran', 'Email', 'Password'],
            User::all(['name', 'email', 'role'])->map(fn ($u) => [
                $u->role->getLabel(),
                $u->email,
                'password',
            ])->toArray()
        );
    }
}
