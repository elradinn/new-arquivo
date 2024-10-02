<?php

namespace Domain\DocumentApprovalHasUser\States;

class UserApproved extends UserApprovalState
{
    public function label(): string
    {
        return 'approved';
    }
}
