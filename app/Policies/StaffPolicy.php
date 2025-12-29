<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class StaffPolicy
{
    use ChecksSchoolAccess;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $user->hasPermissionTo('view_any_staff');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $staff): bool
    {
        if (! $this->sameSchool($user, $staff)) {
            return false;
        }

        return $user->hasPermissionTo('view_staff');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $user->hasPermissionTo('create_staff');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $staff): bool
    {
        if (! $this->sameSchool($user, $staff)) {
            return false;
        }

        return $user->hasPermissionTo('edit_staff');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $staff): bool
    {
        if (! $this->sameSchool($user, $staff)) {
            return false;
        }

        return $user->hasPermissionTo('delete_staff');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $staff): bool
    {
        if (! $this->sameSchool($user, $staff)) {
            return false;
        }

        return $user->hasPermissionTo('restore_staff');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $staff): bool
    {
        if (! $this->sameSchool($user, $staff)) {
            return false;
        }

        return $user->hasPermissionTo('force_delete_staff');
    }
}
