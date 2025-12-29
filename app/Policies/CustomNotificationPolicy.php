<?php

namespace App\Policies;

use App\Models\CustomNotification;
use App\Models\User;

class CustomNotificationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['school_admin', 'school-admin'], true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomNotification $customNotification): bool
    {
        return in_array($user->role, ['school_admin', 'school-admin'], true)
            && $customNotification->school_id === $user->school_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['school_admin', 'school-admin'], true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomNotification $customNotification): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomNotification $customNotification): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomNotification $customNotification): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomNotification $customNotification): bool
    {
        return false;
    }
}
