<?php

namespace Domain\DocumentApproval\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Domain\DocumentApproval\Models\DocumentApproval;

class DocumentApprovalRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $documentApproval;

    public function __construct(DocumentApproval $documentApproval)
    {
        $this->documentApproval = $documentApproval;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You have a new document approval request.')
            ->action('View Document Approval', url('/document-approvals/' . $this->documentApproval->id))
            ->line('Thank you for using our application!');
    }
}
