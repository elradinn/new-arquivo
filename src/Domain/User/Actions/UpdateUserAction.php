<?php

namespace Domain\User\Actions;

use Domain\User\Data\UpdateUserData;
use Domain\User\Models\User;

class UpdateUserAction
{
    public function execute(User $user, UpdateUserData $data): User
    {
        $user->update([
            'name' => $data->name,
        ]);

        return $user;
    }
}
