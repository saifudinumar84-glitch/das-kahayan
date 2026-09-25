<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Sampling;
use App\Models\User;

class SamplingPolicy
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

    public function view(User $user, Sampling $sampling): bool
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
        return in_array($user->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true);
    }

    public function update(User $user, Sampling $sampling): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true);
    }

    public function delete(User $user, Sampling $sampling): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function restore(User $user, Sampling $sampling): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }

    public function forceDelete(User $user, Sampling $sampling): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function publish(User $user, Sampling $sampling): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::TeamLeader], true);
    }
}
