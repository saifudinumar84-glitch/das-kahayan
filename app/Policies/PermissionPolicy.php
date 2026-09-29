<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageUsers->value)
            || $user->role === UserRole::Admin;
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageUsers->value)
            || $user->role === UserRole::Admin;
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function restore(User $user, Permission $permission): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user, Permission $permission): bool
    {
        return $user->role === UserRole::Admin;
    }
}
