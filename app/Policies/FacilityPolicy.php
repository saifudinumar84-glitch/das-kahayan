<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Facility;
use App\Models\User;

class FacilityPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            UserRole::Admin,
            UserRole::Inspector,
            UserRole::TeamLeader,
            UserRole::Head,
            UserRole::Business,
        ], true);
    }

    public function view(User $user, Facility $facility): bool
    {
        if ($user->role === UserRole::Business) {
            return $user->facilities()->where('facilities.id', $facility->id)->exists();
        }

        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true);
    }

    public function update(User $user, Facility $facility): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true);
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
