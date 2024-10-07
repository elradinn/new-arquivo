<?php

namespace Domain\DocumentApproval\Models;

use Domain\Item\Models\Item;
use Domain\Document\Models\Document;
use Domain\User\Models\User;
use Domain\DocumentApproval\States\DocumentState;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DocumentApproval extends Model
{
    use HasUuids, HasStates;

    protected $fillable = [
        'document_id',
        'resolution',
        'destination',
        'type',
        'overall_state',
    ];

    protected $casts = [
        'overall_state' => DocumentState::class,
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
