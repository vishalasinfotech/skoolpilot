<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\User;

class ExamPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_exam');
    }

    public function view(User $user, Exam $exam): bool
    {
        return $user->can('view_exam') && $user->school_id === $exam->school_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create_exam') && $user->school_id !== null;
    }

    public function update(User $user, Exam $exam): bool
    {
        return $user->can('edit_exam') && $user->school_id === $exam->school_id;
    }

    public function delete(User $user, Exam $exam): bool
    {
        return $user->can('delete_exam') && $user->school_id === $exam->school_id;
    }
}
