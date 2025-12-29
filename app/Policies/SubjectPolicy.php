<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class SubjectPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_subject');
    }

    public function view(User $user, Subject $subject): bool
    {
        if (! $this->sameSchool($user, $subject)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_subject');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_subject');
    }

    public function update(User $user, Subject $subject): bool
    {
        if (! $this->sameSchool($user, $subject)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_subject');
    }

    public function delete(User $user, Subject $subject): bool
    {
        if (! $this->sameSchool($user, $subject)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_subject');
    }
}
