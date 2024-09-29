<?php

namespace Domain\DocumentApproval\States;

class Pending extends DocumentApprovalState
{
    public function label(): string
    {
        return 'pending';
    }
}
