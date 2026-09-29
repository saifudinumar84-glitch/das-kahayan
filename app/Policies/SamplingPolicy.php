<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\Sampling;
use App\Models\User;

class SamplingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSamplings->value)
            || $user->hasPermissionTo(PermissionType::ViewReports->value);
    }

    public function view(User $user, Sampling $sampling): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSamplings->value)
            || $user->hasPermissionTo(PermissionType::ViewReports->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSamplings->value);
    }

    public function update(User $user, Sampling $sampling): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSamplings->value);
    }

    public function delete(User $user, Sampling $sampling): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSamplings->value)
            && in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function restore(User $user, Sampling $sampling): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSamplings->value)
            && in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function forceDelete(User $user, Sampling $sampling): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function publish(User $user, Sampling $sampling): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageSamplings->value)
            && in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }
}
