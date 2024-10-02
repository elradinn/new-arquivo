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
        $this->app->bind(CreateWorkspaceAction::class, function ($app) {
            return new CreateWorkspaceAction($app->make(\Domain\Item\Actions\CreateItemAction::class));
        });

        $this->app->bind(CreateFolderAction::class, function ($app) {
            return new CreateFolderAction($app->make(\Domain\Item\Actions\CreateItemAction::class));
        });

        $this->app->bind(UploadDocumentAction::class, function ($app) {
            return new UploadDocumentAction($app->make(\Domain\Item\Actions\CreateItemAction::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
