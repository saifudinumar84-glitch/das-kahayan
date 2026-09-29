<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\SupervisionPlan;
use App\Models\User;

class SupervisionPlanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaRencanaKerja->value)
            || $user->hasPermissionTo(PermissionType::LihatLaporan->value);
    }

    public function view(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaRencanaKerja->value)
            || $user->hasPermissionTo(PermissionType::LihatLaporan->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaRencanaKerja->value);
    }

    public function update(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaRencanaKerja->value);
    }

    public function delete(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaRencanaKerja->value)
            && in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function restore(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaRencanaKerja->value)
            && in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function forceDelete(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return $user->role === UserRole::Admin;
    }
}
