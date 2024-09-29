<?php

namespace Domain\Document\Data;

use Spatie\LaravelData\Data;

class DocumentUploadData extends Data
{
    public function __construct(
        public int $parent_id,
        public string $name
    ) {}
}
