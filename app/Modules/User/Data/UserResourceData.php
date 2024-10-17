<?php

namespace App\Modules\User\Data;

use Spatie\LaravelData\Resource;

class UserResourceData extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $workflow_role,
    ) {}
}
