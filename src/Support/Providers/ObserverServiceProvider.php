<?php

namespace Support\Providers;

use Illuminate\Support\ServiceProvider;

use Domain\Document\Models\Document;
use Domain\Folder\Models\Folder;
use Domain\Workspace\Models\Workspace;
use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;

use Domain\Document\Observers\DocumentLoggingObserver;
use Domain\Folder\Observers\FolderLoggingObserver;
use Domain\Workspace\Observers\WorkspaceLoggingObserver;
use Domain\DocumentApproval\Observers\DocumentApprovalLoggingObserver;
use Domain\DocumentApprovalHasUser\Observers\DocumentApprovalHasUserLoggingObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Document::observe(DocumentLoggingObserver::class);
        Folder::observe(FolderLoggingObserver::class);
        Workspace::observe(WorkspaceLoggingObserver::class);
        DocumentApproval::observe(DocumentApprovalLoggingObserver::class);
        DocumentApprovalHasUser::observe(DocumentApprovalHasUserLoggingObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
