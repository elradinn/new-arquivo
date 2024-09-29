<?php

namespace Domain\DocumentApprovalHasUser\Events;

use Domain\DocumentApproval\Models\DocumentApproval;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserApprovalUpdated
{
    use Dispatchable, SerializesModels;

    public $documentApproval;

    /**
     * Create a new event instance.
     *
     * @param DocumentApproval $documentApproval
     */
    public function __construct(DocumentApproval $documentApproval)
    {
        $this->documentApproval = $documentApproval;
    }
}
