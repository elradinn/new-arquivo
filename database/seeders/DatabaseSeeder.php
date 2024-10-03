<?php

namespace Database\Seeders;

use Domain\User\Models\User;
use Illuminate\Database\Seeder;
use Domain\Workspace\Actions\CreateWorkspaceAction;
use Domain\Workspace\Data\CreateWorkspaceData;
use Domain\Folder\Actions\CreateFolderAction;
use Domain\Folder\Data\CreateFolderData;
use Domain\Document\Actions\UploadDocumentAction;
use Domain\Document\Data\UploadDocumentData;
use Domain\Metadata\Models\Metadata;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);

        User::create([
            'name' => 'Test Approval',
            'email' => 'testapproval@example.com',
            'password' => '12345678',
        ]);

        // Create Metadata
        Metadata::create([
            'name' => 'Country',
            'type' => 'string',
        ]);

        Metadata::create([
            'name' => 'Published Year',
            'type' => 'integer',
        ]);

        Metadata::create([
            'name' => 'Is Confidential',
            'type' => 'boolean',
        ]);

        // Create Workspace
        $createWorkspaceAction = app(CreateWorkspaceAction::class);
        $workspace = $createWorkspaceAction->execute(new CreateWorkspaceData(
            name: 'Test Workspace'
        ));

        // Create Folder
        $createFolderAction = app(CreateFolderAction::class);
        $folder = $createFolderAction->execute(new CreateFolderData(
            parent_id: $workspace->item_id,
            name: 'Test Folder'
        ));

        // Create Document
        $uploadDocumentAction = app(UploadDocumentAction::class);
        $uploadDocumentAction->execute(new UploadDocumentData(
            parent_id: $folder->item_id,
            name: 'Test Document'
        ));
    }
}
