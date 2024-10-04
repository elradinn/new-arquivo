<?php

namespace Domain\Document\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Uuid;

class UploadDocumentData extends Data
{
    public function __construct(
        #[Uuid()]
        public string $parent_id,

        public string $name
    ) {}
}