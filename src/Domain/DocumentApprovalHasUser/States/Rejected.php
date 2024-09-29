<?php

namespace Domain\DocumentApprovalHasUser\States;

class Rejected extends UserApprovalState
{
    public function label(): string
    {
        return 'rejected';
    }
}
