<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;

class SectionPolicy
{
    /**
     * A teacher can only view a list of their own sections.
     * The dashboard already handles this, but we'll keep the policy strict.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'teacher';
    }

    /**
     * A teacher can only view their own specific section.
     */
    public function view(User $user, Section $section): bool
    {
        return $user->teacher && $user->teacher->id === $section->teacher_id;
    }

    /**
     * A teacher can only update grades for their own section.
     */
    public function update(User $user, Section $section): bool
    {
        return $user->teacher && $user->teacher->id === $section->teacher_id;
    }

    // For a teacher, we can deny all other actions.
    public function create(User $user): bool
    {
        return false;
    }

    public function delete(User $user, Section $section): bool
    {
        return false;
    }

    public function restore(User $user, Section $section): bool
    {
        return false;
    }

    public function forceDelete(User $user, Section $section): bool
    {
        return false;
    }
}
