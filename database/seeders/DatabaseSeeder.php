<?php

namespace Database\Seeders;

use Domain\User\Models\User;
use Illuminate\Database\Seeder;
use Domain\Workspace\Actions\CreateWorkspaceAction;
use Domain\Workspace\Data\CreateWorkspaceData;
use Domain\Folder\Actions\CreateFolderAction;
use Domain\Folder\Data\CreateFolderData;
use Domain\Document\Actions\CreateDocumentAction;
use Domain\Document\Data\DocumentUploadData;
use Domain\Metadata\Models\Metadata;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        $user1 = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);

        $user2 = User::create([
            'name' => 'Test Approval',
            'email' => 'testapproval@example.com',
            'password' => '12345678',
        ]);

        // // Create a workspace
        // $createWorkspaceAction = app(CreateWorkspaceAction::class);
        // $workspaceData = new CreateWorkspaceData(name: 'Test Workspace');
        // $createWorkspaceAction->execute($workspaceData);

        // // Retrieve the created workspace item
        // $workspaceItem = \Domain\Item\Models\Item::whereHas('workspace', function ($query) {
        //     $query->where('name', 'Test Workspace');
        // })->first();

        // // Create a folder within the workspace
        // $createFolderAction = app(CreateFolderAction::class);
        // $folderData = new CreateFolderData(parent_id: $workspaceItem->id, name: 'Test Folder');
        // $createFolderAction->execute($folderData);

        // // // Retrieve the created folder item
        // // $folderItem = \Domain\Item\Models\Item::whereHas('folder', function ($query) {
        // //     $query->where('name', 'Test Folder');
        // // })->first();

        // // // Create a document within the folder
        // // $createDocumentAction = app(CreateDocumentAction::class);
        // // $documentData = new DocumentUploadData(parent_id: $folderItem->id, name: 'Test Document');
        // // $createDocumentAction->execute($documentData);

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
    }
}
