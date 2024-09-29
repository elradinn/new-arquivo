<?php

namespace Domain\Document\Models;

use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\Item\Models\Item;
use Domain\Folder\Models\Folder;
use Domain\Metadata\Models\Metadata;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Document extends Model
{
    protected $primaryKey = 'item_id'; // Use item_id as the primary key
    public $incrementing = false; // Since item_id is not auto-incrementing integer

    protected $fillable = [
        'item_id',
        'name',
        'owned_by',
        'document_number',
        'status',
        'description',
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
}
