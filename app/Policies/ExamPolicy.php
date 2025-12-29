<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class ExamPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_exam');
    }

    public function view(User $user, Exam $exam): bool
    {
        if (! $this->sameSchool($user, $exam)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_exam');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_exam');
    }

    public function update(User $user, Exam $exam): bool
    {
        if (! $this->sameSchool($user, $exam)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_exam');
    }

    public function delete(User $user, Exam $exam): bool
    {
        if (! $this->sameSchool($user, $exam)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_exam');
    }
}
