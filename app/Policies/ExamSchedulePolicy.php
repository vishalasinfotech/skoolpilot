<?php

namespace App\Policies;

use App\Models\ExamSchedule;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class ExamSchedulePolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_exam_schedule');
    }

    public function view(User $user, ExamSchedule $examSchedule): bool
    {
        if (! $this->sameSchool($user, $examSchedule)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_exam_schedule');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_exam_schedule');
    }

    public function update(User $user, ExamSchedule $examSchedule): bool
    {
        if (! $this->sameSchool($user, $examSchedule)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_exam_schedule');
    }

    public function delete(User $user, ExamSchedule $examSchedule): bool
    {
        if (! $this->sameSchool($user, $examSchedule)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_exam_schedule');
    }
}
