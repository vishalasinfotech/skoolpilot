<?php

namespace App\Policies;

use App\Models\Transportation;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class TransportationPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_transportation');
    }

    public function view(User $user, Transportation $transportation): bool
    {
        if (! $this->sameSchool($user, $transportation)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_transportation');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_transportation');
    }

    public function update(User $user, Transportation $transportation): bool
    {
        if (! $this->sameSchool($user, $transportation)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_transportation');
    }

    public function delete(User $user, Transportation $transportation): bool
    {
        if (! $this->sameSchool($user, $transportation)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_transportation');
    }
}
