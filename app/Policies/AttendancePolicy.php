<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_attendance');
    }

    public function view(User $user, Attendance $attendance): bool
    {
        return $user->can('view_attendance') && $user->school_id === $attendance->school_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create_attendance') && $user->school_id !== null;
    }

    public function update(User $user, Attendance $attendance): bool
    {
        return $user->can('edit_attendance') && $user->school_id === $attendance->school_id;
    }

    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->can('delete_attendance') && $user->school_id === $attendance->school_id;
    }
}
