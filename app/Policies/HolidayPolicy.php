<?php

namespace App\Policies;

use App\Models\Holiday;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class HolidayPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_holiday');
    }

    public function view(User $user, Holiday $holiday): bool
    {
        if (! $this->sameSchool($user, $holiday)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_holiday');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_holiday');
    }

    public function update(User $user, Holiday $holiday): bool
    {
        if (! $this->sameSchool($user, $holiday)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_holiday');
    }

    public function delete(User $user, Holiday $holiday): bool
    {
        if (! $this->sameSchool($user, $holiday)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_holiday');
    }
}
