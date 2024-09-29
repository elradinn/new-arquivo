<?php

namespace Support\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\ActivityLog\Observers\DocumentApprovalHasUserObserver;
use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\ActivityLog\Observers\DocumentApprovalObserver;
use Domain\Folder\Models\Folder;
use Domain\ActivityLog\Observers\FolderObserver;
use Domain\Workspace\Models\Workspace;
use Domain\ActivityLog\Observers\WorkspaceObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DocumentApprovalHasUser::observe(DocumentApprovalHasUserObserver::class);
        DocumentApproval::observe(DocumentApprovalObserver::class);
        Folder::observe(FolderObserver::class);
        Workspace::observe(WorkspaceObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
