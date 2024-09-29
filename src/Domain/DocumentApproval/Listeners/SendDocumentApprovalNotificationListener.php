<?php

namespace Domain\DocumentApproval\Listeners;

use Domain\DocumentApproval\Events\DocumentApprovalCreated;
use Domain\DocumentApproval\Notifications\DocumentApprovalRequestNotification;
use Illuminate\Support\Facades\Notification;

class SendDocumentApprovalNotificationListener
{
    public function handle(DocumentApprovalCreated $event): void
    {
        $users = $event->documentApproval->users;
        Notification::send($users, new DocumentApprovalRequestNotification($event->documentApproval));
    }
}
