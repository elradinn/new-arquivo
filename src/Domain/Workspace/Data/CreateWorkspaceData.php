<?php

namespace Domain\Workspace\Data;

use Spatie\LaravelData\Data;

class CreateWorkspaceData extends Data
{
    public function __construct(
        public string $name
    ) {}
}
