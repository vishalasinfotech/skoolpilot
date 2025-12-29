<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class AttendancePolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_attendance');
    }

    public function view(User $user, Attendance $attendance): bool
    {
        if (! $this->sameSchool($user, $attendance)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_attendance');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_attendance');
    }

    public function update(User $user, Attendance $attendance): bool
    {
        if (! $this->sameSchool($user, $attendance)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_attendance');
    }

    public function delete(User $user, Attendance $attendance): bool
    {
        if (! $this->sameSchool($user, $attendance)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_attendance');
    }
}
