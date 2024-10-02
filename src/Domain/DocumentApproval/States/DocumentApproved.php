<?php

namespace Domain\DocumentApproval\States;

class DocumentApproved extends DocumentApprovalState
{
    public function label(): string
    {
        return 'approved';
    }
}
