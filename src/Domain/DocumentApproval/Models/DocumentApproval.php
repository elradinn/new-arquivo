<?php

namespace Domain\DocumentApproval\Models;

use Domain\Document\Models\Document;
use Domain\DocumentApproval\States\DocumentApprovalState;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\Item\Models\Item;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;

class DocumentApproval extends Model
{
    use SoftDeletes, HasStates;

    protected $fillable = [
        'document_id',
        'resolution',
        'overall_state',
        'destination',
    ];

    protected $casts = [
        'overall_state' => DocumentApprovalState::class,
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function destinationItem()
    {
        return $this->belongsTo(Item::class, 'destination');
    }

    public function documentApprovalUsers()
    {
        return $this->hasMany(DocumentApprovalHasUser::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, DocumentApprovalHasUser::class, 'document_approval_id', 'id', 'id', 'user_id');
    }
}
