<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\SupervisionPlan;
use App\Models\User;

class SupervisionPlanPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            UserRole::Admin,
            UserRole::Inspector,
            UserRole::TeamLeader,
            UserRole::Head,
        ], true);
    }

    public function view(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return in_array($user->role, [
            UserRole::Admin,
            UserRole::Inspector,
            UserRole::TeamLeader,
            UserRole::Head,
        ], true);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function update(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function delete(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function restore(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function forceDelete(User $user, SupervisionPlan $supervisionPlan): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }
}
