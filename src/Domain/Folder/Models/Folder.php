<?php

namespace Domain\Folder\Models;

use Domain\Item\Models\Item;
use Domain\Workflow\Models\Workflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Folder extends Model
{
    protected $primaryKey = 'item_id'; // Use item_id as the primary key

    protected $fillable = [
        'name',
        'owned_by',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function workflow(): HasOne
    {
        return $this->hasOne(Workflow::class, 'folder_id');
    }
}
