<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Inspection;
use App\Models\User;

class InspectionPolicy
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

    public function view(User $user, Inspection $inspection): bool
    {
        if ($user->role === UserRole::Business) {
            return $user->facilities()->where('facilities.id', $inspection->facility_id)->exists();
        }

        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true);
    }

    public function update(User $user, Inspection $inspection): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true);
    }

    public function delete(User $user, Inspection $inspection): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function restore(User $user, Inspection $inspection): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function forceDelete(User $user, Inspection $inspection): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function publish(User $user, Inspection $inspection): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }
}
