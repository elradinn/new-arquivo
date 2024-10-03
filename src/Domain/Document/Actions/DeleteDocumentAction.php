<?php

namespace Domain\Document\Actions;

use Domain\Document\Models\Document;
use Domain\Item\Actions\DeleteItemAction;

class DeleteDocumentAction
{
    public function __construct(
        protected DeleteItemAction $deleteItemAction
    ) {}

    public function execute(Document $document): void
    {
        $this->deleteItemAction->execute($document->item);
    }
}
