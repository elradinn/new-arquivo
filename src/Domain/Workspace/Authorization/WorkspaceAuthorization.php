<?php

namespace Domain\Workspace\Authorization;

use Domain\User\Models\User;
use Domain\Workspace\Models\Workspace;
use Illuminate\Auth\Access\AuthorizationException;

class WorkspaceAuthorization
{
    public function before(User $user): ?bool
    {
        if ($user->hasRole('v')) {
            return true;
        }

        return null;
    }

    public function canView(User $user, Workspace $workspace): void
    {
        if ($this->before($user, 'view') !== null) {
            if ($this->before($user, 'view')) {
                return;
            }
            throw new AuthorizationException('Unauthorized');
        }

        if (!$workspace->users()->where('user_id', $user->id)->exists()) {
            throw new AuthorizationException('Unauthorized');
        }
    }

    public function canEdit(User $user, Workspace $workspace): void
    {
        if ($this->before($user, 'edit') !== null) {
            if ($this->before($user, 'edit')) {
                return;
            }
            throw new AuthorizationException('Unauthorized');
        }

        if (!$workspace->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'editor')
            ->exists()) {
            throw new AuthorizationException('Unauthorized');
        }
    }

    public function canShare(User $user, Workspace $workspace): void
    {
        if ($this->before($user, 'share') !== null) {
            if ($this->before($user, 'share')) {
                return;
            }
            throw new AuthorizationException('Unauthorized');
        }

        if (!$workspace->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'editor')
            ->exists()) {
            throw new AuthorizationException('Unauthorized');
        }
    }
}
