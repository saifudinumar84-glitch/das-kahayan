<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\CapaSubmission;
use App\Models\User;

class CapaSubmissionPolicy
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

    public function view(User $user, CapaSubmission $capaSubmission): bool
    {
        if ($user->role === UserRole::Business) {
            $facilityId = $capaSubmission->finding?->inspection?->facility_id;

            return $facilityId && $user->facilities()->where('facilities.id', $facilityId)->exists();
        }

        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Business], true);
    }

    public function update(User $user, CapaSubmission $capaSubmission): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true);
    }

    public function delete(User $user, CapaSubmission $capaSubmission): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function restore(User $user, CapaSubmission $capaSubmission): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user, CapaSubmission $capaSubmission): bool
    {
        return $user->role === UserRole::Admin;
    }
}
