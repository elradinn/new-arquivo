<?php

namespace Modules\Document\Models;

use Modules\DocumentApproval\Models\DocumentApproval;
use Modules\Item\Models\Item;
use Modules\Folder\Models\Folder;
use Modules\Metadata\Models\Metadata;
use Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\ActivityLog\Models\ActivityLog;
use Modules\DocumentApproval\States\DocumentState;
use Spatie\Activitylog\Models\Activity;
use Spatie\ModelStates\HasStates;

class Document extends Model
{
    use HasUuids, HasStates;

    protected $primaryKey = 'item_id'; // Use item_id as the primary key
    public $incrementing = false; // Since item_id is not auto-incrementing integer

    protected $fillable = [
        'item_id',
        'name',
        'owned_by',
        'document_number',
        'status',
        'description',
        'mime',
        'size',
        'file_path',
    ];

    protected $casts = [
        'status' => DocumentState::class,
    ];

    /**
     * Get the document's items.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the document's approval.
     */
    public function documentApproval(): HasOne
    {
        return $this->hasOne(DocumentApproval::class, 'document_id', 'item_id');
    }

    /**
     * The metadata associated with the document.
     */
    public function metadata(): BelongsToMany
    {
        return $this->belongsToMany(Metadata::class, 'document_has_metadata', 'document_id', 'metadata_id')
            ->withPivot('value')
            ->withTimestamps();
    }

    /**
     * Get the related documents.
     */
    public function relatedDocuments(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'related_documents', 'document_id', 'related_document_id')
            ->withTimestamps();
    }

    /**
     * Get the related to documents (for bidirectional relationship).
     */
    public function relatedToDocuments(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'related_documents', 'related_document_id', 'document_id')
            ->withTimestamps();
    }

    public function userAccess(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_document_access', 'document_id', 'user_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
