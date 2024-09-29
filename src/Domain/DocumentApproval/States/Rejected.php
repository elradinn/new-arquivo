<?php

namespace Domain\DocumentApproval\States;

class Rejected extends DocumentApprovalState
{
    public function label(): string
    {
        return 'rejected';
    }
}
