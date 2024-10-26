<?php

namespace Modules\DocumentApproval\Actions;

use Modules\DocumentApproval\Data\UpdateDocumentApprovalData;
use Modules\DocumentApproval\Models\DocumentApproval;
use Modules\DocumentApproval\States\DocumentApprovalPending;
use Modules\DocumentApproval\States\DocumentReviewalPending;
use Modules\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Modules\DocumentApprovalHasUser\States\UserApprovalPending;
use Modules\DocumentApprovalHasUser\States\UserReviewalPending;
use Modules\User\Models\User;

class UpdateDocumentApprovalAction
{
    public function __construct(
        protected SendDocumentApprovalNotificationAction $sendDocumentApprovalNotificationAction
    ) {}

    public function execute(DocumentApproval $documentApproval, UpdateDocumentApprovalData $data): array
    {
        $documentApproval->update([
            'resolution' => $data->resolution,
            'type' => $data->type,
            'overall_state' => $data->type === 'reviewal' ? DocumentReviewalPending::class : DocumentApprovalPending::class,
        ]);

        // Determine required role based on the new type
        $requiredRole = $this->getRequiredRole($data->type);

        if ($requiredRole) {
            // Filter users based on the required role
            $filteredUsers = User::whereIn('id', array_map(fn($user) => $user->user_id, $data->users))
                ->where('workflow_role', $requiredRole)
                ->get();

            // Delete existing users
            $documentApproval->documentApprovalUsers()->delete();

            // Create new users
            collect($filteredUsers)->each(function ($user) use ($documentApproval, $requiredRole) {
                DocumentApprovalHasUser::create([
                    'document_approval_id' => $documentApproval->id,
                    'user_id' => $user->id,
                    'user_state' => $requiredRole === 'reviewer' ? UserReviewalPending::class : UserApprovalPending::class,
                ]);
            });

            $this->sendDocumentApprovalNotificationAction->execute($documentApproval);
        }

        return ['documentApproval' => $documentApproval->load('documentApprovalUsers')];
    }

    /**
     * Determines the required user role based on the document approval type.
     *
     * @param string $type
     * @return string|null
     */
    private function getRequiredRole(string $type): ?string
    {
        return match ($type) {
            'reviewal' => 'reviewer',
            'approval' => 'approver',
            default => null,
        };
    }
}
