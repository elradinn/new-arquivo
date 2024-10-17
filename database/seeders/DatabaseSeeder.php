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

        //TODO: workflow roles have unassigned, reviewer, approver

        // Create Users
        $testUser1 = User::create([
            'name' => 'John Alfred',
            'email' => 'adminuser@example.com',
            'password' => '12345678',
            'workflow_role' => 'unassigned',
        ]);

        $testUser1->assignRole('admin');

        $testUser2 = User::create([
            'name' => 'Angelo',
            'email' => 'revieweruser1@example.com',
            'password' => '12345678',
            'workflow_role' => 'reviewer',
        ]);

        $testUser3 = User::create([
            'name' => 'Geryme',
            'email' => 'revieweruser2@example.com',
            'password' => '12345678',
            'workflow_role' => 'reviewer',
        ]);

        $testUser4 = User::create([
            'name' => 'Mark Elthon',
            'email' => 'approvaluser@example.com',
            'password' => '12345678',
            'workflow_role' => 'approver',
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
            name: 'Administrative',
            owned_by: $testUser1->id
        ));

        $workspace = $createWorkspaceAction->execute(new CreateWorkspaceData(
            name: 'Applications',
            owned_by: $testUser1->id
        ));

        $workspace = $createWorkspaceAction->execute(new CreateWorkspaceData(
            name: 'Services',
            owned_by: $testUser1->id
        ));

        $workspace = $createWorkspaceAction->execute(new CreateWorkspaceData(
            name: 'Partnerships',
            owned_by: $testUser1->id
        ));

        $workspace = $createWorkspaceAction->execute(new CreateWorkspaceData(
            name: 'Test Folder',
            owned_by: $testUser1->id
        ));

        // Create Folder
        $createFolderAction = app(CreateFolderAction::class);
        $createFolderAction->execute(new CreateFolderData(
            parent_id: $workspace->item_id,
            name: 'Meetings',
            owned_by: $testUser1->id
        ));
    }
}
