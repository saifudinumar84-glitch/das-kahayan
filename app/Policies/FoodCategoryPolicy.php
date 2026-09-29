<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\FoodCategory;
use App\Models\User;

class FoodCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaPangan->value)
            || $user->hasPermissionTo(PermissionType::LihatLaporan->value);
    }

    public function view(User $user, FoodCategory $foodCategory): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaPangan->value)
            || $user->hasPermissionTo(PermissionType::LihatLaporan->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaPangan->value);
    }

    public function update(User $user, FoodCategory $foodCategory): bool
    {
        return $user->hasPermissionTo(PermissionType::KelolaPangan->value);
    }

    public function delete(User $user, FoodCategory $foodCategory): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function restore(User $user, FoodCategory $foodCategory): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user, FoodCategory $foodCategory): bool
    {
        return $user->role === UserRole::Admin;
    }
}
