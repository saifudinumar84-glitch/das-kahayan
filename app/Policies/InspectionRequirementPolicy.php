<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\InspectionRequirement;
use App\Models\User;

class InspectionRequirementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaPersyaratanInspeksi->value)
            || $user->hasPermissionTo(PermissionType::KelolaInspeksi->value)
            || $user->hasPermissionTo(PermissionType::LihatLaporan->value);
    }

    public function view(User $user, InspectionRequirement $inspectionRequirement): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaPersyaratanInspeksi->value);
    }

    public function update(User $user, InspectionRequirement $inspectionRequirement): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaPersyaratanInspeksi->value);
    }

    public function delete(User $user, InspectionRequirement $inspectionRequirement): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function restore(User $user, InspectionRequirement $inspectionRequirement): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user, InspectionRequirement $inspectionRequirement): bool
    {
        return $user->role === UserRole::Admin;
    }
}
