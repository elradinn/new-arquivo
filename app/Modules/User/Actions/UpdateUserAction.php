<?php

namespace Modules\User\Actions;

use Modules\User\Data\UpdateUserData;
use Modules\User\Models\User;

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
