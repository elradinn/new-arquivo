<?php

namespace Domain\Document\Actions;

use Domain\Document\Data\DocumentUploadData;
use Domain\Document\Models\Document;
use Domain\Item\Actions\CreateItemAction;
use Domain\Item\Data\CreateItemData;
use Illuminate\Support\Facades\Auth;

class UploadDocumentAction
{

    public function __construct(
        protected CreateItemAction $createItemAction,
    ) {}

    public function execute(DocumentUploadData $data): Document
    {
        $item = $this->createItemAction->execute(
            CreateItemData::from([
                'parent_id' => $data->parent_id,
            ])
        );

        return $item->document()->create([
            'name' => $data->name,
            'owned_by' => Auth::id(),
        ]);
    }
}
