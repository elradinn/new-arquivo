<?php

namespace Domain\DocumentApproval\Actions;

use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApproval\Notifications\DocumentApprovalRequestNotification;
use Illuminate\Support\Facades\Notification;

class SendDocumentApprovalNotificationAction
{
    public function execute(DocumentApproval $documentApproval): void
    {
        $users = $documentApproval->users;
        Notification::send($users, new DocumentApprovalRequestNotification($documentApproval));
    }
}
