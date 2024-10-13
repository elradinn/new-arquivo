<?php

namespace Modules\DocumentApproval\Models;

use Modules\Item\Models\Item;
use Modules\Document\Models\Document;
use Modules\User\Models\User;
use Modules\DocumentApproval\States\DocumentState;
use Modules\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
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
        return $this->belongsTo(Document::class, 'document_id', 'item_id');
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
