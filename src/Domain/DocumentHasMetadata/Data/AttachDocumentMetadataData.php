<?php

namespace Domain\DocumentHasMetadata\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\StringType;

class AttachDocumentMetadataData extends Data
{
    public function __construct(
        #[Required, Exists('metadata', 'id')]
        public int $metadata_id,

        #[Required, StringType]
        public string $value
    ) {}
}
