<?php

namespace Domain\Workspace\Data;

use Spatie\LaravelData\Data;

class UpdateWorkspaceData extends Data
{
    public function __construct(
        public string $name
    ) {}
}
