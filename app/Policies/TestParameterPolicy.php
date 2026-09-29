<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\TestParameter;
use App\Models\User;

class TestParameterPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaParameterUji->value)
            || $user->hasPermissionTo(PermissionType::KelolaSampling->value)
            || $user->hasPermissionTo(PermissionType::LihatLaporan->value);
    }

    public function view(User $user, TestParameter $testParameter): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaParameterUji->value);
    }

    public function update(User $user, TestParameter $testParameter): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaParameterUji->value);
    }

    public function delete(User $user, TestParameter $testParameter): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function restore(User $user, TestParameter $testParameter): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user, TestParameter $testParameter): bool
    {
        return $user->role === UserRole::Admin;
    }
}
