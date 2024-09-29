<?php

namespace Domain\DocumentApprovalHasUser\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class UserApprovalState extends State
{
    abstract public function label(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Approved::class)
            ->allowTransition(Pending::class, Rejected::class);
    }
}
