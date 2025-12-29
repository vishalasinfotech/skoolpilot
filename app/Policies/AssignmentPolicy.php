<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class AssignmentPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_assignment');
    }

    public function view(User $user, Assignment $assignment): bool
    {
        if (! $this->sameSchool($user, $assignment)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_assignment');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_assignment');
    }

    public function update(User $user, Assignment $assignment): bool
    {
        if (! $this->sameSchool($user, $assignment)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_assignment');
    }

    public function delete(User $user, Assignment $assignment): bool
    {
        if (! $this->sameSchool($user, $assignment)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_assignment');
    }
}
