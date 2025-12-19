<?php

namespace App\Policies;

use App\Models\Result;
use App\Models\User;

class ResultPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_result');
    }

    public function view(User $user, Result $result): bool
    {
        return $user->can('view_result') && $user->school_id === $result->school_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create_result') && $user->school_id !== null;
    }

    public function update(User $user, Result $result): bool
    {
        return $user->can('edit_result') && $user->school_id === $result->school_id;
    }

    public function delete(User $user, Result $result): bool
    {
        return $user->can('delete_result') && $user->school_id === $result->school_id;
    }
}
