<?php

namespace App\Policies;

use App\Models\StudentFeeTransaction;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class StudentFeeTransactionPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_student_fee_transaction');
    }

    public function view(User $user, StudentFeeTransaction $studentFeeTransaction): bool
    {
        if (! $this->sameSchool($user, $studentFeeTransaction)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_student_fee_transaction');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_student_fee_transaction');
    }

    public function update(User $user, StudentFeeTransaction $studentFeeTransaction): bool
    {
        if (! $this->sameSchool($user, $studentFeeTransaction)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_student_fee_transaction');
    }

    public function delete(User $user, StudentFeeTransaction $studentFeeTransaction): bool
    {
        if (! $this->sameSchool($user, $studentFeeTransaction)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_student_fee_transaction');
    }
}
