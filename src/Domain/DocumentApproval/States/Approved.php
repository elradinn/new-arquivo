<?php

namespace Domain\DocumentApproval\States;

class Approved extends DocumentApprovalState
{
    public function label(): string
    {
        return 'approved';
    }
}
