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
        public ?string $file_path,
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
            file_path: $item->document->file_path ?? null
        );
    }
}
