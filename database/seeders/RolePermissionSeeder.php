<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar Permission sesuai PRD SI KAHAYAN BBPOM Palangka Raya
        $permissions = [
            // Pengawasan & Temuan
            'view-inspections',
            'create-inspections',
            'update-inspections',
            'delete-inspections',

            // Sampling & Pengujian Laboratorium
            'view-samplings',
            'create-samplings',
            'update-samplings',
            'delete-samplings',

            // CAPA (Corrective and Preventive Action)
            'submit-capa',
            'review-capa',
            'verify-capa',
            'approve-capa',

            // Laporan & Export (PDF & Excel)
            'view-reports',
            'export-reports',

            // Master Data & User Management
            'manage-users',
            'manage-facilities',
            'manage-master-data',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // 1. Role: Administrator
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // 2. Role: Petugas Layanan / Inspektur
        $inspectorRole = Role::firstOrCreate(['name' => 'inspector', 'guard_name' => 'web']);
        $inspectorRole->syncPermissions([
            'view-inspections',
            'create-inspections',
            'update-inspections',
            'view-samplings',
            'create-samplings',
            'update-samplings',
            'review-capa',
            'view-reports',
            'export-reports',
        ]);

        // 3. Role: Ketua Tim
        $teamLeaderRole = Role::firstOrCreate(['name' => 'team_leader', 'guard_name' => 'web']);
        $teamLeaderRole->syncPermissions([
            'view-inspections',
            'update-inspections',
            'view-samplings',
            'update-samplings',
            'review-capa',
            'verify-capa',
            'view-reports',
            'export-reports',
        ]);

        // 4. Role: Kepala Balai (Pimpinan)
        $headRole = Role::firstOrCreate(['name' => 'head', 'guard_name' => 'web']);
        $headRole->syncPermissions([
            'view-inspections',
            'view-samplings',
            'approve-capa',
            'view-reports',
            'export-reports',
        ]);

        // 5. Role: Pelaku Usaha (Business)
        $businessRole = Role::firstOrCreate(['name' => 'business', 'guard_name' => 'web']);
        $businessRole->syncPermissions([
            'submit-capa',
            'view-inspections',
            'view-reports',
        ]);

        // Sync Spatie role for all existing users
        foreach (User::all() as $user) {
            if ($user->role) {
                $roleValue = is_string($user->role) ? $user->role : $user->role->value;
                $user->syncRoles([$roleValue]);
            }
        }
    }
}
