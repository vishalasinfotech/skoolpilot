<?php

namespace App\Policies;

use App\Models\AcademicSession;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class AcademicSessionPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_academic_session');
    }

    public function view(User $user, AcademicSession $academicSession): bool
    {
        if (! $this->sameSchool($user, $academicSession)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_academic_session');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_academic_session');
    }

    public function update(User $user, AcademicSession $academicSession): bool
    {
        if (! $this->sameSchool($user, $academicSession)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_academic_session');
    }

    public function delete(User $user, AcademicSession $academicSession): bool
    {
        if (! $this->sameSchool($user, $academicSession)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_academic_session');
    }
}
