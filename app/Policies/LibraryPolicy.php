<?php

namespace App\Policies;

use App\Models\Library;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class LibraryPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_library');
    }

    public function view(User $user, Library $library): bool
    {
        if (! $this->sameSchool($user, $library)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_library');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_library');
    }

    public function update(User $user, Library $library): bool
    {
        if (! $this->sameSchool($user, $library)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_library');
    }

    public function delete(User $user, Library $library): bool
    {
        if (! $this->sameSchool($user, $library)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_library');
    }
}
