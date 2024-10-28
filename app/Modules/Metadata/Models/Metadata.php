<?php

namespace Modules\Metadata\Models;

use Modules\Document\Models\Document;
use Modules\Folder\Models\Folder;
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

    /**
     * The folders that belong to the metadata.
     */
    public function folders(): BelongsToMany
    {
        return $this->belongsToMany(Folder::class, 'folder_has_required_metadata', 'metadata_id', 'folder_item_id')
            ->withTimestamps();
    }
}
