<?php

namespace Domain\User\Actions;

use Domain\User\Models\User;

class DeleteUserAction
{
    public function execute(User $user): void
    {
        $user->delete();
    }
}
