<?php

namespace Modules\Document\Data;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UpdateDocumentData extends Data
{
    /**
     * @param AttachDocumentMetadataData[] $metadata
     */
    public function __construct(
        #[Required]
        public string $name,

        public ?string $document_number,

        public ?string $description,

        public array $metadata,

        public ?array $related_documents,
    ) {}
}
