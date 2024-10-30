<?php

namespace Modules\Item\Data;

use Spatie\LaravelData\Resource;
use Modules\Item\Models\Item;

class ItemContentsResourceData extends Resource
{
    public function __construct(
        public string $id,
        public ?string $owned_by,
        public ?string $name,
        public ?string $mime,
        public ?string $size,
        public ?string $type,
        public ?string $document_number,
        public ?string $status,
        public ?string $description,
        public ?string $updated_at,
        public ?string $file_path,
        public ?bool $missing_required_metadata = true, // TODO: make logic to check if the document is missing required metadata
        public ?array $metadata = null
    ) {}

    public static function fromModel(Item $item): self
    {
        return new self(
            id: $item->id,
            owned_by: $item->folder->owned_by ?? null,
            name: $item->folder->name ?? $item->document->name ?? null,
            mime: $item->document->mime ?? null,
            size: $item->document->size ?? null,
            type: $item->document ? 'document' : 'folder',
            document_number: $item->document->document_number ?? null,
            status: $item->document && $item->document->status ? $item->document->status->label() : null,
            description: $item->document->description ?? null,
            updated_at: $item->document->updated_at ?? null,
            file_path: $item->document->file_path ?? null,
            metadata: $item->document ? $item->document->metadata()->get()->map(fn($metadata) => [
                'id' => $metadata->id,
                'name' => $metadata->name,
                'value' => $metadata->pivot->value,
            ])->toArray() : null,
        );
    }
}
