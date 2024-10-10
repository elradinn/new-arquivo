<?php

namespace Modules\Document\Actions;

use Modules\Document\Models\Document;
use Modules\Item\Actions\DeleteItemAction;

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
