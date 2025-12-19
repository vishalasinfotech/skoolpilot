<?php

namespace App\Policies;

use App\Models\User;

class TeacherPolicy
{
    /**
     * Check if user is school admin (role-based access).
     */
    private function isSchoolAdmin(User $user): bool
    {
        return in_array($user->role, ['school_admin', 'school-admin'], true);
    }

    /**
     * Check if user has permission (Spatie Permission) or is school admin.
     */
    private function hasPermissionOrIsAdmin(User $user, string $permission): bool
    {
        // School admins have access by role
        if ($this->isSchoolAdmin($user)) {
            return true;
        }

        // Check Spatie permission if assigned
        return $user->can($permission);
    }

    /**
     * Check multi-tenancy: ensure users belong to same school.
     */
    private function sameSchool(User $user, ?User $teacher = null): bool
    {
        // User must have a school_id
        if ($user->school_id === null) {
            return false;
        }

        // For viewAny/create, only check user has school_id
        if ($teacher === null) {
            return true;
        }

        // For specific teacher, must belong to same school
        if ($teacher->school_id === null) {
            return false;
        }

        return $user->school_id === $teacher->school_id;
    }

    public function viewAny(User $user): bool
    {
        // Multi-tenancy: must have school_id
        if (! $this->sameSchool($user)) {
            return false;
        }

        // Permission or role-based access
        return $this->hasPermissionOrIsAdmin($user, 'view_any_teacher');
    }

    public function view(User $user, User $teacher): bool
    {
        // Must be a teacher
        if (! $teacher->isTeacher()) {
            return false;
        }

        // Multi-tenancy: must belong to same school
        if (! $this->sameSchool($user, $teacher)) {
            return false;
        }

        // Permission or role-based access
        return $this->hasPermissionOrIsAdmin($user, 'view_teacher');
    }

    public function create(User $user): bool
    {
        // Multi-tenancy: must have school_id
        if (! $this->sameSchool($user)) {
            return false;
        }

        // Permission or role-based access
        return $this->hasPermissionOrIsAdmin($user, 'create_teacher');
    }

    public function update(User $user, User $teacher): bool
    {
        // Must be a teacher
        if (! $teacher->isTeacher()) {
            return false;
        }

        // Multi-tenancy: must belong to same school
        if (! $this->sameSchool($user, $teacher)) {
            return false;
        }

        // Permission or role-based access
        return $this->hasPermissionOrIsAdmin($user, 'edit_teacher');
    }

    public function delete(User $user, User $teacher): bool
    {
        return $user->can('delete_teacher') && $teacher->isTeacher() && $user->school_id === $teacher->school_id;
    }
}
