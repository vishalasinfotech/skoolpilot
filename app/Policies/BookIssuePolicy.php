<?php

namespace App\Policies;

use App\Models\BookIssue;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class BookIssuePolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_issued_books');
    }

    public function view(User $user, BookIssue $bookIssue): bool
    {
        if (! $this->sameSchool($user, $bookIssue)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_issued_books');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_issued_books');
    }

    public function update(User $user, BookIssue $bookIssue): bool
    {
        if (! $this->sameSchool($user, $bookIssue)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_issued_books');
    }

    public function delete(User $user, BookIssue $bookIssue): bool
    {
        if (! $this->sameSchool($user, $bookIssue)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_issued_books');
    }
}
