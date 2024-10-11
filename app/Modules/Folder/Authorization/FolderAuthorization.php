<?php

namespace Modules\Folder\Authorization;

use Modules\User\Models\User;
use Modules\Folder\Models\Folder;
use Illuminate\Auth\Access\AuthorizationException;

class FolderAuthorization
{
    private function authorize(User $user, callable $callback)
    {
        if ($this->before($user)) {
            return true;
        }

        return $callback();
    }

    private function before(User $user): ?bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    public function isAdmin(User $user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        throw new AuthorizationException('Unauthorized');
    }

    public function canView(User $user, Folder $folder)
    {
        return $this->authorize($user, function () use ($folder, $user) {
            if (!$folder->userAccess()->where('user_id', $user->id)->exists()) {
                throw new AuthorizationException('You don`t have permission to view this folder');
            }
        });
    }

    public function canEdit(User $user, Folder $folder)
    {
        return $this->authorize($user, function () use ($folder, $user) {
            if (!$folder->userAccess()
                ->where('user_id', $user->id)
                ->wherePivot('role', 'editor')
                ->exists()) {
                throw new AuthorizationException('You don`t have permission to edit this folder');
            }
        });
    }

    public function canShare(User $user, Folder $folder)
    {
        $this->authorize($user, function () use ($folder, $user) {
            if (!$folder->userAccess()
                ->where('user_id', $user->id)
                ->wherePivot('role', 'editor')
                ->exists()) {
                throw new AuthorizationException('You don`t have permission to share this folder');
            }
        });
    }
}