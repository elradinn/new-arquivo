<?php

namespace Modules\Document\Authorization;

use Modules\User\Models\User;
use Modules\Document\Models\Document;
use Illuminate\Auth\Access\AuthorizationException;

class DocumentAuthorization
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

    public function canView(User $user, Document $document)
    {
        return $this->authorize($user, function () use ($document, $user) {
            if (!$document->userAccess()->where('user_id', $user->id)->exists()) {
                throw new AuthorizationException('You don`t have permission to view this document');
            }
        });
    }

    public function canEdit(User $user, Document $document)
    {
        return $this->authorize($user, function () use ($document, $user) {
            if (!$document->userAccess()
                ->where('user_id', $user->id)
                ->wherePivot('role', 'editor')
                ->exists()) {
                throw new AuthorizationException('You don`t have permission to edit this document');
            }
        });
    }

    public function canShare(User $user, Document $document)
    {
        $this->authorize($user, function () use ($document, $user) {
            if (!$document->userAccess()
                ->where('user_id', $user->id)
                ->wherePivot('role', 'editor')
                ->exists()) {
                throw new AuthorizationException('You don`t have permission to share this document');
            }
        });
    }
}
