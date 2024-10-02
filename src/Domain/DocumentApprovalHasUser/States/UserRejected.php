<?php

namespace Domain\DocumentApprovalHasUser\States;

class UserRejected extends UserApprovalState
{
    public function label(): string
    {
        return 'rejected';
    }
}
