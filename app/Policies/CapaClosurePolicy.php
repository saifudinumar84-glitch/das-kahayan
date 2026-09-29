<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\CapaClosure;
use App\Models\User;

class CapaClosurePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::VerifikasiCapa->value)
            || $user->hasPermissionTo(PermissionType::SetujuiCapa->value)
            || $user->hasPermissionTo(PermissionType::ReviewCapa->value)
            || $user->hasPermissionTo(PermissionType::LihatLaporan->value);
    }

    public function view(User $user, CapaClosure $capaClosure): bool
    {
        if ($user->role === UserRole::Business) {
            $facilityId = $capaClosure->inspection?->facility_id;

            return $facilityId && $user->facilities()->where('facilities.id', $facilityId)->exists();
        }

        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::VerifikasiCapa->value);
    }

    public function update(User $user, CapaClosure $capaClosure): bool
    {
        return $user->hasPermissionTo(PermissionType::VerifikasiCapa->value)
            || $user->hasPermissionTo(PermissionType::SetujuiCapa->value);
    }

    public function delete(User $user, CapaClosure $capaClosure): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function restore(User $user, CapaClosure $capaClosure): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user, CapaClosure $capaClosure): bool
    {
        return $user->role === UserRole::Admin;
    }
}
