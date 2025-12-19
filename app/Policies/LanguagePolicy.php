<?php

namespace App\Policies;

use App\Models\Language;
use App\Models\User;

class LanguagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_language');
    }

    public function view(User $user, Language $language): bool
    {
        return $user->can('view_language');
    }

    public function create(User $user): bool
    {
        return $user->can('create_language');
    }

    public function update(User $user, Language $language): bool
    {
        return $user->can('update_language');
    }

    public function delete(User $user, Language $language): bool
    {
        return $user->can('delete_language');
    }
}
