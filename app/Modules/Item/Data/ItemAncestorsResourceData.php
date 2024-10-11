<?php

namespace Modules\Item\Data;

use Spatie\LaravelData\Data;
use Modules\Item\Models\Item;

class ItemAncestorsResourceData extends Data
{
    public function __construct(
        public string $name,
        public string $url
    ) {}

    public static function fromModel(Item $item): self
    {
        $type = $item->workspace ? 'workspace' : 'folder';
        $url = sprintf('%s/%s', $type, $item->id);

        return new self(
            name: $item->workspace->name ?? $item->folder->name ?? null,
            url: $url
        );
    }
}
