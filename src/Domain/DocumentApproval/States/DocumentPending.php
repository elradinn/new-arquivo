<?php

namespace Domain\DocumentApproval\States;

class DocumentPending extends DocumentApprovalState
{
    public function label(): string
    {
        return 'pending';
    }
}
