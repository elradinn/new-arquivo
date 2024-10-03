<?php

namespace Support\Providers;

use Illuminate\Support\ServiceProvider;

use Domain\Document\Models\Document;
use Domain\Folder\Models\Folder;
use Domain\Workspace\Models\Workspace;
use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\User\Models\User;
use Domain\Workflow\Models\Workflow;
use Domain\Metadata\Models\Metadata;
use Domain\NumberingScheme\Models\NumberingScheme;

use Domain\Document\Observers\DocumentLogObserver;
use Domain\Workspace\Observers\WorkspaceLogObserver;
use Domain\Folder\Observers\FolderLogObserver;
use Domain\DocumentApproval\Observers\DocumentApprovalLogObserver;
use Domain\DocumentApprovalHasUser\Observers\DocumentApprovalHasUserLogObserver;
use Domain\User\Observers\UserLogObserver;
use Domain\Workflow\Observers\WorkflowLogObserver;
use Domain\Metadata\Observers\MetadataLogObserver;
use Domain\NumberingScheme\Observers\NumberingSchemeLogObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Document::observe(DocumentLogObserver::class);
        Folder::observe(FolderLogObserver::class);
        Workspace::observe(WorkspaceLogObserver::class);
        DocumentApproval::observe(DocumentApprovalLogObserver::class);
        DocumentApprovalHasUser::observe(DocumentApprovalHasUserLogObserver::class);
        User::observe(UserLogObserver::class);
        Workflow::observe(WorkflowLogObserver::class);
        Metadata::observe(MetadataLogObserver::class);
        NumberingScheme::observe(NumberingSchemeLogObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
