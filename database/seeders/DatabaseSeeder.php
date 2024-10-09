<?php

namespace Database\Seeders;

use Modules\User\Models\User;
use Illuminate\Database\Seeder;
use Modules\Workspace\Actions\CreateWorkspaceAction;
use Modules\Workspace\Data\CreateWorkspaceData;
use Modules\Folder\Actions\CreateFolderAction;
use Modules\Folder\Data\CreateFolderData;
use Modules\Metadata\Models\Metadata;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Create Users
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);

        $testUser->assignRole('admin');

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
        $createFolderAction->execute(new CreateFolderData(
            parent_id: $workspace->item_id,
            name: 'Test Folder'
        ));

        // // Create Document
        // $uploadDocumentAction = app(UploadDocumentAction::class);
        // $uploadDocumentAction->execute(new UploadDocumentData(
        //     parent_id: $folder->item_id,
        //     name: 'Test Document'
        // ));


    }
}
