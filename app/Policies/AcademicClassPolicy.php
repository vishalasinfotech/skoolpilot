<?php

namespace App\Policies;

use App\Models\AcademicClass;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class AcademicClassPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_academic_class');
    }

    public function view(User $user, AcademicClass $academicClass): bool
    {
        if (! $this->sameSchool($user, $academicClass)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_academic_class');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_academic_class');
    }

    public function update(User $user, AcademicClass $academicClass): bool
    {
        if (! $this->sameSchool($user, $academicClass)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_academic_class');
    }

    public function delete(User $user, AcademicClass $academicClass): bool
    {
        if (! $this->sameSchool($user, $academicClass)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_academic_class');
    }
}
