<?php

namespace Domain\DocumentApproval\Events;

use Domain\DocumentApproval\Models\DocumentApproval;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentApprovalCreated
{
    use Dispatchable, SerializesModels;

    public $documentApproval;

    public function __construct(DocumentApproval $documentApproval)
    {
        $this->documentApproval = $documentApproval;
    }
}
