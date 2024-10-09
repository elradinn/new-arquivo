<?php

namespace Domain\Workspace\Models;

use Domain\Item\Models\Item;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Workspace extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'item_id'; // Use item_id as the primary key

    protected $fillable = [
        'item_id',
        'name',
        'owned_by',
    ];

    /**
     * Get the workspace's items.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_workspace_access', 'workspace_id', 'user_id')
            ->withPivot('role')
            ->withTimestamps();
    }
}
