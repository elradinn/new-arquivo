<?php

namespace Domain\DocumentApprovalHasUser\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Domain\User\Models\User;
use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApprovalHasUser\Events\UserApprovalUpdated;
use Domain\DocumentApprovalHasUser\States\UserApprovalState;
use Spatie\ModelStates\HasStates;

class DocumentApprovalHasUser extends Model
{
    use SoftDeletes, HasStates;

    protected $fillable = [
        'document_approval_id',
        'user_id',
        'user_state',
        'comment',
    ];

    protected $casts = [
        'user_state' => UserApprovalState::class,
    ];

    public function documentApproval()
    {
        return $this->belongsTo(DocumentApproval::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot method to handle model events
     */
    protected static function booted()
    {
        // Trigger the event after a user decision is saved
        static::saved(function ($userApproval) {
            event(new UserApprovalUpdated($userApproval->documentApproval));
        });
    }
}
