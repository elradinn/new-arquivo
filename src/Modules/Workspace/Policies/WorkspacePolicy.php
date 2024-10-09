<?php

namespace Modules\Workspace\Policies;

use Modules\User\Models\User;
use Modules\Workspace\Models\Workspace;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkspacePolicy
{
    use HandlesAuthorization;

    /**
     * Grant all abilities to admin.
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('vi')) {
            return true;
        }
    }

    public function view(User $user, Workspace $workspace)
    {
        return $workspace->users()->where('user_id', $user->id)->exists();
    }

    public function edit(User $user, Workspace $workspace)
    {
        return $workspace->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'editor')
            ->exists();
    }

    public function share(User $user, Workspace $workspace)
    {
        return $workspace->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'editor')
            ->exists();
    }
}
