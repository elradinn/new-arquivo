<?php

namespace Domain\Document\Policies;

use Domain\User\Models\User;
use Domain\Document\Models\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
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

    public function view(User $user, Document $document)
    {
        return $document->users()->where('user_id', $user->id)->exists();
    }

    public function edit(User $user, Document $document)
    {
        return $document->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'editor')
            ->exists();
    }

    public function share(User $user, Document $document)
    {
        return $document->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'editor')
            ->exists();
    }
}
