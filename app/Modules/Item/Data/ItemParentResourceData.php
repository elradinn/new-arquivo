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
        public ?string $numbering_scheme_id = null,
        public ?string $workflow_id = null,
        public ?array $required_metadata = null
    ) {}

    public static function fromModel(Item $item): self
    {
        return new self(
            item_id: $item->id,
            name: $item->workspace->name ?? $item->folder->name ?? null,
            owned_by: $item->workspace->owned_by ?? $item->folder->owned_by ?? null,
            numbering_scheme_id: $item->folder->numberingScheme->id ?? null,
            workflow_id: $item->folder->workflow->id ?? null,
            required_metadata: $item->workspace ? [] : $item->folder->requiredMetadata()->get()->toArray() ?? []
        );
    }
}
