<?php

namespace Domain\Folder\Policies;

use Domain\User\Models\User;
use Domain\Folder\Models\Folder;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolderPolicy
{
    use HandlesAuthorization;

    /**
     * Grant all abilities to admin.
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    public function view(User $user, Folder $folder)
    {
        return $folder->users()->where('user_id', $user->id)->exists();
    }

    public function edit(User $user, Folder $folder)
    {
        return $folder->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'editor')
            ->exists();
    }

    public function share(User $user, Folder $folder)
    {
        return $folder->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'editor')
            ->exists();
    }
}
