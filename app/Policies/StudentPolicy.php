<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class StudentPolicy
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

        return $user->hasPermissionTo('view_any_student');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $student): bool
    {
        if (! $this->sameSchool($user, $student)) {
            return false;
        }

        return $user->hasPermissionTo('view_student');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $user->hasPermissionTo('create_student');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $student): bool
    {
        if (! $this->sameSchool($user, $student)) {
            return false;
        }

        return $user->hasPermissionTo('edit_student');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $student): bool
    {
        if (! $this->sameSchool($user, $student)) {
            return false;
        }

        return $user->hasPermissionTo('delete_student');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $student): bool
    {
        if (! $this->sameSchool($user, $student)) {
            return false;
        }

        return $user->hasPermissionTo('restore_student');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $student): bool
    {
        if (! $this->sameSchool($user, $student)) {
            return false;
        }

        return $user->hasPermissionTo('delete_student');
    }
}
