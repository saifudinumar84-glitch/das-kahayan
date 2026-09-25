<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\CapaClosure;
use App\Models\User;

class CapaClosurePolicy
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

    public function view(User $user, CapaClosure $capaClosure): bool
    {
        if ($user->role === UserRole::Business) {
            $facilityId = $capaClosure->inspection?->facility_id;

            return $facilityId && $user->facilities()->where('facilities.id', $facilityId)->exists();
        }

        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true);
    }

    public function update(User $user, CapaClosure $capaClosure): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader, UserRole::Head], true);
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
