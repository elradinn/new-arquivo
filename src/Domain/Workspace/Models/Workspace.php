<?php

namespace Domain\Workspace\Models;

use Domain\Item\Models\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workspace extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id'; // Use item_id as the primary key

    protected $fillable = [
        'name',
        'owned_by',
    ];

    /**
     * Get the workspace's items.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
