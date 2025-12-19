<?php

namespace App\Policies;

use App\Models\ExamSchedule;
use App\Models\User;

class ExamSchedulePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_exam_schedule');
    }

    public function view(User $user, ExamSchedule $examSchedule): bool
    {
        return $user->can('view_exam_schedule') && $user->school_id === $examSchedule->school_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create_exam_schedule') && $user->school_id !== null;
    }

    public function update(User $user, ExamSchedule $examSchedule): bool
    {
        return $user->can('edit_exam_schedule') && $user->school_id === $examSchedule->school_id;
    }

    public function delete(User $user, ExamSchedule $examSchedule): bool
    {
        return $user->can('delete_exam_schedule') && $user->school_id === $examSchedule->school_id;
    }
}
