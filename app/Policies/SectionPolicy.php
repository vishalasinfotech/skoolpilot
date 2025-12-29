<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class SectionPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_section');
    }

    public function view(User $user, Section $section): bool
    {
        if (! $this->sameSchool($user, $section)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_section');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_section');
    }

    public function update(User $user, Section $section): bool
    {
        if (! $this->sameSchool($user, $section)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_section');
    }

    public function delete(User $user, Section $section): bool
    {
        if (! $this->sameSchool($user, $section)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_section');
    }
}
