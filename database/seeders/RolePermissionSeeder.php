<?php

namespace Database\Seeders;

use App\Enums\PermissionType;
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

        // Buat semua permission dari enum PermissionType
        foreach (PermissionType::cases() as $permission) {
            Permission::firstOrCreate(['name' => $permission->value, 'guard_name' => 'web']);
        }

        // 1. Role: Administrator — akses penuh ke semua permission
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(PermissionType::values());

        // 2. Role: Petugas Layanan / Inspektur
        $inspectorRole = Role::firstOrCreate(['name' => 'inspector', 'guard_name' => 'web']);
        $inspectorRole->syncPermissions([
            PermissionType::KelolaInspeksi->value,
            PermissionType::KelolaSampling->value,
            PermissionType::ReviewCapa->value,
            PermissionType::LihatLaporan->value,
            PermissionType::ExportLaporan->value,
        ]);

        // 3. Role: Ketua Tim
        $teamLeaderRole = Role::firstOrCreate(['name' => 'team_leader', 'guard_name' => 'web']);
        $teamLeaderRole->syncPermissions([
            PermissionType::KelolaInspeksi->value,
            PermissionType::KelolaSampling->value,
            PermissionType::KelolaRencanaKerja->value,
            PermissionType::ReviewCapa->value,
            PermissionType::VerifikasiCapa->value,
            PermissionType::LihatLaporan->value,
            PermissionType::ExportLaporan->value,
        ]);

        // 4. Role: Kepala Balai (Pimpinan)
        $headRole = Role::firstOrCreate(['name' => 'head', 'guard_name' => 'web']);
        $headRole->syncPermissions([
            PermissionType::SetujuiCapa->value,
            PermissionType::LihatLaporan->value,
            PermissionType::ExportLaporan->value,
        ]);

        // 5. Role: Pelaku Usaha (Business)
        $businessRole = Role::firstOrCreate(['name' => 'business', 'guard_name' => 'web']);
        $businessRole->syncPermissions([
            PermissionType::KirimCapa->value,
            PermissionType::LihatLaporan->value,
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
