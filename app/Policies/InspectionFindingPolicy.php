<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\InspectionFinding;
use App\Models\User;

class InspectionFindingPolicy
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

    public function view(User $user, InspectionFinding $inspectionFinding): bool
    {
        if ($user->role === UserRole::Business) {
            $facilityId = $inspectionFinding->inspection?->facility_id;

            return $facilityId && $user->facilities()->where('facilities.id', $facilityId)->exists();
        }

        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true);
    }

    public function update(User $user, InspectionFinding $inspectionFinding): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true);
    }

    public function delete(User $user, InspectionFinding $inspectionFinding): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function restore(User $user, InspectionFinding $inspectionFinding): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function forceDelete(User $user, InspectionFinding $inspectionFinding): bool
    {
        return $user->role === UserRole::Admin;
    }
}
