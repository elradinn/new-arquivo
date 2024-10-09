<?php

namespace Support\Providers;

use Domain\Document\Models\Document;
use Domain\Document\Policies\DocumentPolicy;
use Domain\Folder\Models\Folder;
use Domain\Folder\Policies\FolderPolicy;
use Domain\Workspace\Models\Workspace;
use Domain\Workspace\Policies\WorkspacePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policies(Workspace::class, WorkspacePolicy::class);
        Gate::policy(Folder::class, FolderPolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);
    }
}
