<?php

namespace App\Policies;

use App\Models\LeaveApplication;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class LeaveApplicationPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_apply_for_leave');
    }

    public function view(User $user, LeaveApplication $leaveApplication): bool
    {
        if (! $this->sameSchool($user, $leaveApplication)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_apply_for_leave');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_apply_for_leave');
    }

    public function update(User $user, LeaveApplication $leaveApplication): bool
    {
        if (! $this->sameSchool($user, $leaveApplication)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_apply_for_leave');
    }

    public function delete(User $user, LeaveApplication $leaveApplication): bool
    {
        if (! $this->sameSchool($user, $leaveApplication)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_apply_for_leave');
    }
}
