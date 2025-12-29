<?php

namespace App\Policies\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait ChecksSchoolAccess
{
    /**
     * Check multi-tenancy: ensure user and model belong to same school.
     */
    protected function sameSchool(User $user, ?Model $model = null): bool
    {
        if ($user->school_id === null) {
            return false;
        }

        if ($model === null) {
            return true;
        }

        if ($model->school_id === null) {
            return false;
        }

        return $user->school_id === $model->school_id;
    }

    /**
     * Check if user is school admin.
     */
    protected function isSchoolAdmin(User $user): bool
    {
        return in_array($user->role, ['school_admin', 'school-admin'], true);
    }

    /**
     * Check if user has permission (Spatie Permission) or is school admin.
     */
    protected function hasPermissionOrIsAdmin(User $user, string $permission): bool
    {
        if ($this->isSchoolAdmin($user)) {
            return true;
        }

        return $user->hasPermissionTo($permission);
    }
}
