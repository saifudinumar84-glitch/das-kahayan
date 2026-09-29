<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\InspectionFinding;
use App\Models\User;

class InspectionFindingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageInspections->value)
            || $user->hasPermissionTo(PermissionType::ViewReports->value)
            || $user->role === UserRole::Business;
    }

    public function view(User $user, InspectionFinding $inspectionFinding): bool
    {
        if ($user->role === UserRole::Business) {
            $facilityId = $inspectionFinding->inspection?->facility_id;

            return $facilityId && $user->facilities()->where('facilities.id', $facilityId)->exists();
        }

        return $user->hasPermissionTo(PermissionType::ManageInspections->value)
            || $user->hasPermissionTo(PermissionType::ViewReports->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageInspections->value);
    }

    public function update(User $user, InspectionFinding $inspectionFinding): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageInspections->value);
    }

    public function delete(User $user, InspectionFinding $inspectionFinding): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageInspections->value)
            && in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function restore(User $user, InspectionFinding $inspectionFinding): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageInspections->value)
            && in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function forceDelete(User $user, InspectionFinding $inspectionFinding): bool
    {
        return $user->role === UserRole::Admin;
    }
}
