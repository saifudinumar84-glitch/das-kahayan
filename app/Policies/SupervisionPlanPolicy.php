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
        return $user->hasPermissionTo(PermissionType::ManageSupervisionPlans->value)
            || $user->hasPermissionTo(PermissionType::ViewReports->value);
    }

    public function view(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSupervisionPlans->value)
            || $user->hasPermissionTo(PermissionType::ViewReports->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSupervisionPlans->value);
    }

    public function update(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSupervisionPlans->value);
    }

    public function delete(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSupervisionPlans->value)
            && in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function restore(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSupervisionPlans->value)
            && in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function forceDelete(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return $user->role === UserRole::Admin;
    }
}
