<?php

namespace Domain\DocumentApprovalHasUser\States;

class Pending extends UserApprovalState
{
    public function label(): string
    {
        return 'pending';
    }
}
