<?php

namespace Domain\DocumentApproval\States;

class DocumentRejected extends DocumentApprovalState
{
    public function label(): string
    {
        return 'rejected';
    }
}
