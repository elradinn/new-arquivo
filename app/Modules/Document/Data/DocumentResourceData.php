<?php

namespace Modules\Document\Data;

use Spatie\LaravelData\Resource;
use Modules\Document\Models\Document;

class DocumentResourceData extends Resource
{
    public function __construct(
        public string $item_id,
        public string $name,
        public ?string $document_number,
        public ?string $status,
        public ?string $description,
        public ?string $file_path,
        public ?string $document_approval_id,
        public array $related_documents,
        public array $metadata,
        public string $created_at,
        public string $updated_at
    ) {}

    public static function fromModel(Document $document): self
    {
        return new self(
            item_id: $document->item_id,
            name: $document->name,
            document_number: $document->document_number,
            status: $document->status,
            description: $document->description,
            file_path: $document->file_path,
            document_approval_id: $document->documentApproval?->id,
            related_documents: $document->relatedDocuments->map(fn($relatedDocument) => [
                'id' => $relatedDocument->id,
                'item_id' => $relatedDocument->item_id,
                'name' => $relatedDocument->name,
            ])->toArray(),
            metadata: $document->metadata->map(fn($metadata) => [
                'metadata_id' => $metadata->id,
                'name' => $metadata->name,
                'value' => $metadata->pivot->value,
            ])->toArray(),
            created_at: $document->created_at,
            updated_at: $document->updated_at
        );
    }
}
