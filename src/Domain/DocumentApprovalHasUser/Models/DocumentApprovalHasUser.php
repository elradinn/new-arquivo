<?php

namespace Domain\DocumentApprovalHasUser\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Domain\User\Models\User;
use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApprovalHasUser\States\UserState;
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
        'user_state' => UserState::class,
    ];

    public function documentApproval()
    {
        return $this->belongsTo(DocumentApproval::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
