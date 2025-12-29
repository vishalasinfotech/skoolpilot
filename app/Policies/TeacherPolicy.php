<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class TeacherPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_teacher');
    }

    public function view(User $user, User $teacher): bool
    {

        if (! $this->sameSchool($user, $teacher)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_teacher');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_teacher');
    }

    public function update(User $user, User $teacher): bool
    {
        if (! $this->sameSchool($user, $teacher)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_teacher');
    }

    public function delete(User $user, User $teacher): bool
    {
        if (! $this->sameSchool($user, $teacher)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_teacher');
    }
}
