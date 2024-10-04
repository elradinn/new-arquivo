<?php

namespace Domain\User\Observers;

use Domain\User\Models\User;
use Illuminate\Support\Facades\Auth;

class UserLogObserver
{
    public function created(User $user)
    {
        activity()
            ->performedOn($user)
            ->causedBy(Auth::id())
            ->log("User created: {$user->name}");
    }

    public function updated(User $user)
    {
        activity()
            ->performedOn($user)
            ->causedBy(Auth::id())
            ->log("User updated: {$user->name}");
    }

    public function deleted(User $user)
    {
        activity()
            ->performedOn($user)
            ->causedBy(Auth::id())
            ->log("User deleted: {$user->name}");
    }
}
