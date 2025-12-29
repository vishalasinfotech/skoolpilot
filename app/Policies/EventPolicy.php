<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use App\Policies\Concerns\ChecksSchoolAccess;

class EventPolicy
{
    use ChecksSchoolAccess;

    public function viewAny(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_any_event');
    }

    public function view(User $user, Event $event): bool
    {
        if (! $this->sameSchool($user, $event)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'view_event');
    }

    public function create(User $user): bool
    {
        if (! $this->sameSchool($user)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'create_event');
    }

    public function update(User $user, Event $event): bool
    {
        if (! $this->sameSchool($user, $event)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'edit_event');
    }

    public function delete(User $user, Event $event): bool
    {
        if (! $this->sameSchool($user, $event)) {
            return false;
        }

        return $this->hasPermissionOrIsAdmin($user, 'delete_event');
    }
}
