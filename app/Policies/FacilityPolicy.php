<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\Facility;
use App\Models\User;

class FacilityPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaSarana->value)
            || $user->hasPermissionTo(PermissionType::LihatLaporan->value)
            || $user->role === UserRole::Business;
    }

    public function view(User $user, Facility $facility): bool
    {
        if ($user->role === UserRole::Business) {
            return $user->facilities()->where('facilities.id', $facility->id)->exists();
        }

        return $user->hasPermissionTo(PermissionType::KelolaSarana->value)
            || $user->hasPermissionTo(PermissionType::LihatLaporan->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaSarana->value);
    }

    public function update(User $user, Facility $facility): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaSarana->value);
    }

    public function delete(User $user, Facility $facility): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function restore(User $user, Facility $facility): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user, Facility $facility): bool
    {
        return $user->role === UserRole::Admin;
    }
}
