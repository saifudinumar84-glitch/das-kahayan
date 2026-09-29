<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Protected system roles that cannot be deleted.
     *
     * @var list<string>
     */
    protected array $protectedRoles = [
        'admin',
        'inspector',
        'team_leader',
        'head',
        'business',
    ];

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageUsers->value)
            || $user->role === UserRole::Admin;
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageUsers->value)
            || $user->role === UserRole::Admin;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageUsers->value)
            || $user->role === UserRole::Admin;
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermissionType::ManageUsers->value)
            || $user->role === UserRole::Admin;
    }

    public function delete(User $user, Role $role): bool
    {
        if (in_array($role->name, $this->protectedRoles, true)) {
            return false;
        }

        return $user->role === UserRole::Admin;
    }

    public function restore(User $user, Role $role): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user, Role $role): bool
    {
        if (in_array($role->name, $this->protectedRoles, true)) {
            return false;
        }

        return $user->role === UserRole::Admin;
    }
}
