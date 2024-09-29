<?php

namespace Domain\Document\Actions;

use Domain\Document\Data\DocumentUploadData;
use Domain\Document\Events\DocumentUploaded;
use Domain\Document\Models\Document;
use Domain\Item\Actions\CreateItemAction;
use Illuminate\Support\Facades\Auth;

class CreateDocumentAction
{
    protected CreateItemAction $createItemAction;

    public function __construct(CreateItemAction $createItemAction)
    {
        $this->createItemAction = $createItemAction;
    }

    public function execute(DocumentUploadData $data)
    {
        $item = $this->createItemAction->execute([
            'parent_id' => $data->parent_id,
        ]);

        $document = new Document([
            'name' => $data->name,
            'owned_by' => Auth::id(),
        ]);

        $document->item()->associate($item);
        $document->save();

        event(new DocumentUploaded($document));
    }
}
