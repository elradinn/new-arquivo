<?php

namespace Domain\Folder\Data;

use Spatie\LaravelData\Data;

class CreateFolderData extends Data
{
    public function __construct(
        public int $parent_id,
        public string $name
    ) {}
}
