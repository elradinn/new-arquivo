<?php

namespace Domain\DocumentApproval\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class DocumentApprovalState extends State
{
    abstract public function label(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(DocumentPending::class)
            ->allowTransition(DocumentPending::class, DocumentApproved::class)
            ->allowTransition(DocumentPending::class, DocumentRejected::class);
    }
}
