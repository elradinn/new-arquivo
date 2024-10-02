<?php

namespace Support\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Domain\Document\Events\DocumentUploaded;
use Domain\Document\Listeners\ApplyDocumentNumberListener;
use Domain\Document\Listeners\CreateDocumentApprovalFromWorkflowListener;
use Domain\DocumentApproval\Events\DocumentApprovalCreated;
use Domain\DocumentApproval\Listeners\SendDocumentApprovalNotificationListener;
use Domain\DocumentApprovalHasUser\Events\UserApprovalUpdated;
use Domain\DocumentApprovalHasUser\Listeners\RecalculateOverallStateListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DocumentUploaded::class => [
            CreateDocumentApprovalFromWorkflowListener::class,
            ApplyDocumentNumberListener::class,
        ],
        DocumentApprovalCreated::class => [
            SendDocumentApprovalNotificationListener::class,
        ],
        UserApprovalUpdated::class => [
            RecalculateOverallStateListener::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
