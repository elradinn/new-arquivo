<?php

namespace Modules\Item\Data;

use Spatie\LaravelData\Data;
use Modules\Item\Models\Item;

class ItemParentResourceData extends Data
{
    public function __construct(
        public string $item_id,
        public string $name,
        public string $owned_by,
        public bool $has_active_numbering_scheme
    ) {}

    public static function fromModel(Item $item): self
    {
        return new self(
            item_id: $item->id,
            name: $item->workspace->name ?? $item->folder->name ?? null,
            owned_by: $item->workspace->owned_by ?? $item->folder->owned_by ?? null,
            has_active_numbering_scheme: $item->folder && $item->folder->numberingScheme ? $item->folder->numberingScheme->exists() : false
        );
    }
}
