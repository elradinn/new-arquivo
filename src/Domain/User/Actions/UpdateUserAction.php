<?php

namespace Domain\User\Actions;

use Domain\User\Data\UpdateUserData;
use Domain\User\Models\User;
use Illuminate\Support\Facades\Auth;


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
