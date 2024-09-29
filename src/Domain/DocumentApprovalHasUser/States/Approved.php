<?php

namespace Domain\DocumentApprovalHasUser\States;

class Approved extends UserApprovalState
{
    public function label(): string
    {
        return 'approved';
    }
}
