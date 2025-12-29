<?php

namespace App\Policies;

use App\Models\Result;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class ResultPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_result');
    }

    public function view(User $user, Result $result): bool
    {
        if (! $this->sameSchool($user, $result)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_result');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_result');
    }

    public function update(User $user, Result $result): bool
    {
        if (! $this->sameSchool($user, $result)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_result');
    }

    public function delete(User $user, Result $result): bool
    {
        if (! $this->sameSchool($user, $result)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_result');
    }
}
