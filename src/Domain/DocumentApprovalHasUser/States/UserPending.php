<?php

namespace Domain\DocumentApprovalHasUser\States;

class UserPending extends UserApprovalState
{
    public function label(): string
    {
        return 'pending';
    }
}
