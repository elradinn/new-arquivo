<?php

namespace Domain\Folder\Data;

use Spatie\LaravelData\Data;

class UpdateFolderData extends Data
{
    public function __construct(
        public string $name
    ) {}
}
