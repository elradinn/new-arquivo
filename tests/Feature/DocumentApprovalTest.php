<?php

namespace Tests\Feature;

use Domain\Document\Actions\CreateDocumentAction;
use Domain\Document\Actions\UploadDocumentAction;
use Domain\Document\Data\UploadDocumentData;
use Domain\Document\Models\Document;
use Domain\DocumentApproval\Actions\CreateDocumentApprovalAction;
use Domain\DocumentApproval\Data\CreateDocumentApprovalData;
use Domain\DocumentApproval\Events\DocumentApprovalCreated;
use Domain\DocumentApproval\Notifications\DocumentApprovalRequestNotification;
use Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DocumentApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_document_approval_process()
    {
        // Fake notifications
        Notification::fake();

        // Create users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        // Ensure users is an instance of the User model
        $user1 = User::find($user1->id);
        $user2 = User::find($user2->id);
        $user3 = User::find($user3->id);

        // Create an instance of CreateDocumentAction
        $createDocumentAction = new UploadDocumentAction(new \Domain\Item\Actions\CreateItemAction());

        // Define the expected UploadDocumentData
        $UploadDocumentData = new UploadDocumentData(
            parent_id: null,
            name: 'Test Document'
        );

        // Execute the action to create the document
        $createDocumentAction->execute($UploadDocumentData);

        // Retrieve the created document
        $document = Document::where('name', 'Test Document')->firstOrFail();

        $this->assertDatabaseHas('documents', [
            'name' => 'Test Document',
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $document->item_id,
        ]);

        $createDocumentApprovalData = new CreateDocumentApprovalData(
            document_id: $document->item_id,
            resolution: 'Test Resolution',
            destination: null, // Pass null or an appropriate value for destination
            users: [
                ['user_id' => $user1->id],
                ['user_id' => $user2->id],
                ['user_id' => $user3->id] // Add user 3
            ]
        );

        $createDocumentApprovalAction = new CreateDocumentApprovalAction();
        $documentApproval = $createDocumentApprovalAction->execute($createDocumentApprovalData);

        // Dispatch the event
        event(new DocumentApprovalCreated($documentApproval));

        // Assert that the notification was sent to the users
        Notification::assertSentTo([$user1, $user2, $user3], DocumentApprovalRequestNotification::class);

        $this->assertDatabaseHas('document_approvals', [
            'document_id' => $document->item_id,
            'resolution' => 'Test Resolution',
        ]);

        $this->assertDatabaseHas('document_approval_has_users', [
            'document_approval_id' => $documentApproval->id,
            'user_id' => $user1->id,
        ]);

        $this->assertDatabaseHas('document_approval_has_users', [
            'document_approval_id' => $documentApproval->id,
            'user_id' => $user2->id,
        ]);

        $this->assertDatabaseHas('document_approval_has_users', [
            'document_approval_id' => $documentApproval->id,
            'user_id' => $user3->id, // Verify user 3's state
        ]);

        // User 1 accepts the document approval
        $this->actingAs($user1)->post("/document-approvals/{$documentApproval->id}/accept")
            ->assertStatus(200)
            ->assertJson(['message' => 'Document approval accepted.']);

        // Verify user 1's state
        $this->assertDatabaseHas('document_approval_has_users', [
            'document_approval_id' => $documentApproval->id,
            'user_id' => $user1->id,
            'user_state' => \Domain\DocumentApprovalHasUser\States\UserApproved::class,
        ]);

        // Verify the overall state of the document approval
        $documentApproval->refresh();
        $this->assertEquals(\Domain\DocumentApproval\States\DocumentPending::class, $documentApproval->overall_state);

        // User 2 accepts the document approval
        $this->actingAs($user2)->post("/document-approvals/{$documentApproval->id}/accept")
            ->assertStatus(200)
            ->assertJson(['message' => 'Document approval accepted.']);

        // Verify user 2's state
        $this->assertDatabaseHas('document_approval_has_users', [
            'document_approval_id' => $documentApproval->id,
            'user_id' => $user2->id,
            'user_state' => \Domain\DocumentApprovalHasUser\States\UserApproved::class,
        ]);

        // Verify the overall state of the document approval
        $documentApproval->refresh();
        $this->assertEquals(\Domain\DocumentApproval\States\DocumentPending::class, $documentApproval->overall_state);

        // User 3 rejects the document approval
        $this->actingAs($user3)->post("/document-approvals/{$documentApproval->id}/reject")
            ->assertStatus(200)
            ->assertJson(['message' => 'Document approval rejected.']);

        // Verify user 3's state
        $this->assertDatabaseHas('document_approval_has_users', [
            'document_approval_id' => $documentApproval->id,
            'user_id' => $user3->id,
            'user_state' => \Domain\DocumentApprovalHasUser\States\UserRejected::class,
        ]);

        // Verify the overall state of the document approval
        $documentApproval->refresh();
        $this->assertEquals(\Domain\DocumentApproval\States\DocumentRejected::class, $documentApproval->overall_state);
    }
}
