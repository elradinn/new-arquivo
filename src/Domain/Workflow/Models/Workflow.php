<?php

namespace Domain\Workflow\Models;

use Domain\Folder\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends Model
{
    protected $fillable = [
        'folder_item_id',
        'resolution',
        'destination',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function workflowUsers(): HasMany
    {
        return $this->hasMany(WorkflowHasUser::class);
    }
}
