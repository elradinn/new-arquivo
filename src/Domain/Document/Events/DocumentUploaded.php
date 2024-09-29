<?php

namespace Domain\Document\Events;

use Domain\Document\Models\Document;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class DocumentUploaded
{
    use Dispatchable, SerializesModels;

    public $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }
}
