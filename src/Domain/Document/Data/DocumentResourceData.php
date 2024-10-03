<?php

namespace App\Document\Resource;

use Spatie\LaravelData\Resource;
use Domain\Document\Models\Document;

class DocumentResourceData extends Resource
{
    public function __construct(
        public string $item_id,
        public string $name,
        public ?string $document_number,
        public ?string $status,
        public ?string $description,
        public array $related_documents,
        public array $metadata
    ) {}

    public static function fromModel(Document $document): self
    {
        return new self(
            item_id: $document->item_id,
            name: $document->name,
            document_number: $document->document_number,
            status: $document->status,
            description: $document->description,
            related_documents: $document->relatedDocuments->map(fn($relatedDocument) => [
                'item_id' => $relatedDocument->item_id,
                'name' => $relatedDocument->name,
            ])->toArray(),
            metadata: $document->metadata->map(fn($metadata) => [
                'name' => $metadata->name,
                'value' => $metadata->pivot->value,
            ])->toArray()
        );
    }
}
