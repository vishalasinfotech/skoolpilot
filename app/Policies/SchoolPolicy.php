<?php

namespace App\Policies;

use App\Models\School;
use App\Models\User;

class SchoolPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_school');
    }

    public function view(User $user, School $school): bool
    {
        return $user->can('view_school');
    }

    public function create(User $user): bool
    {
        return $user->can('create_school');
    }

    public function update(User $user, School $school): bool
    {
        return $user->can('update_school');
    }

    public function delete(User $user, School $school): bool
    {
        return $user->can('delete_school');
    }
}
