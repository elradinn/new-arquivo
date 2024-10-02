<?php

namespace Domain\Folder\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Uuid;

class CreateFolderData extends Data
{
    public function __construct(
        #[Uuid()]
        public string $parent_id,

        public string $name
    ) {}
}
