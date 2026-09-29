<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\UserRole;
use App\Models\CapaSubmission;
use App\Models\User;

class CapaSubmissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::SubmitCapa->value)
            || $user->hasPermissionTo(PermissionType::ReviewCapa->value)
            || $user->hasPermissionTo(PermissionType::ViewReports->value);
    }

    public function view(User $user, CapaSubmission $capaSubmission): bool
    {
        if ($user->role === UserRole::Business) {
            $facilityId = $capaSubmission->finding?->inspection?->facility_id;

            return $facilityId && $user->facilities()->where('facilities.id', $facilityId)->exists();
        }

        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionType::SubmitCapa->value);
    }

    public function update(User $user, CapaSubmission $capaSubmission): bool
    {
        return $user->hasPermissionTo(PermissionType::ReviewCapa->value);
    }

    public function delete(User $user, CapaSubmission $capaSubmission): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function restore(User $user, CapaSubmission $capaSubmission): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user, CapaSubmission $capaSubmission): bool
    {
        return $user->role === UserRole::Admin;
    }
}
