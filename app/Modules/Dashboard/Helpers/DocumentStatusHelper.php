<?php

namespace Modules\Dashboard\Helpers;

class DocumentStatusHelper
{
    protected static $statusMap = [
        'reviewal_pending' => 'Modules\DocumentApproval\States\DocumentReviewalPending',
        'reviewal_accepted' => 'Modules\DocumentApproval\States\DocumentReviewalAccepted',
        'reviewal_rejected' => 'Modules\DocumentApproval\States\DocumentReviewalRejected',
        'approval_pending' => 'Modules\DocumentApproval\States\DocumentApprovalPending',
        'approval_accepted' => 'Modules\DocumentApproval\States\DocumentApprovalAccepted',
        'approval_rejected' => 'Modules\DocumentApproval\States\DocumentApprovalRejected',
    ];

    public static function getStatusClass(string $status): ?string
    {
        return self::$statusMap[$status] ?? null;
    }
}
