<?php

namespace Support\Providers;

use Illuminate\Support\ServiceProvider;

use Domain\Folder\Models\Folder;
use Domain\Folder\Observers\FolderLoggingObserver;
use Domain\Workflow\Observers\WorkspaceLoggingObserver;
use Domain\Workspace\Models\Workspace;

use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApproval\Observers\DocumentApprovalLoggingObserver;
use Domain\DocumentApprovalHasUser\Observers\DocumentApprovalHasUserLoggingObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DocumentApprovalHasUser::observe(DocumentApprovalHasUserLoggingObserver::class);
        DocumentApproval::observe(DocumentApprovalLoggingObserver::class);
        Folder::observe(FolderLoggingObserver::class);
        Workspace::observe(WorkspaceLoggingObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
