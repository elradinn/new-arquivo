<?php

namespace Domain\Document\Data;

use Spatie\LaravelData\Data;

class UpdateDocumentData extends Data
{
    public function __construct(
        public string $name
    ) {}
}
