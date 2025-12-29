<?php

namespace App\Policies;

use App\Models\FeeStructure;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class FeeStructurePolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_fee_structure');
    }

    public function view(User $user, FeeStructure $feeStructure): bool
    {
        if (! $this->sameSchool($user, $feeStructure)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_fee_structure');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_fee_structure');
    }

    public function update(User $user, FeeStructure $feeStructure): bool
    {
        if (! $this->sameSchool($user, $feeStructure)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_fee_structure');
    }

    public function delete(User $user, FeeStructure $feeStructure): bool
    {
        if (! $this->sameSchool($user, $feeStructure)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_fee_structure');
    }
}
