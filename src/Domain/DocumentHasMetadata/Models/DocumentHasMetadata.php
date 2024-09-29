<?php

namespace Domain\DocumentHasMetadata\Models;

use Domain\Document\Models\Document;
use Domain\Metadata\Models\Metadata;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentHasMetadata extends Model
{
    protected $table = 'document_has_metadata';

    protected $fillable = [
        'document_id',
        'metadata_id',
        'value',
    ];

    /**
     * Get the document that owns the metadata.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Get the metadata definition.
     */
    public function metadata(): BelongsTo
    {
        return $this->belongsTo(Metadata::class, 'metadata_id');
    }
}
