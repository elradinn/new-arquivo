<?php

namespace Support\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Workspace\Actions\CreateWorkspaceAction;
use Domain\Folder\Actions\CreateFolderAction;
use Domain\Document\Actions\CreateDocumentAction;
use Domain\Document\Actions\UploadDocumentAction;

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
        //
    }
}
