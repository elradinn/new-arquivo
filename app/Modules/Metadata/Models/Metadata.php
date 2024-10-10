<?php

namespace Modules\Metadata\Models;

use Modules\Document\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Metadata extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    /**
     * The documents that belong to the metadata.
     */
    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'document_has_metadata', 'metadata_id', 'document_id')
            ->withPivot('value')
            ->withTimestamps();
    }
}
