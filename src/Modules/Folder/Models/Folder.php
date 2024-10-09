<?php

namespace Modules\Folder\Models;

use Modules\Item\Models\Item;
use Modules\NumberingScheme\Models\NumberingScheme;
use Modules\User\Models\User;
use Modules\Workflow\Models\Workflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Folder extends Model
{
    use HasUuids;

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
        return $this->hasOne(Workflow::class);
    }

    public function numberingScheme(): HasOne
    {
        return $this->hasOne(NumberingScheme::class);
    }

    public function userAccess(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_folder_access')
            ->withPivot('role')
            ->withTimestamps();
    }
}
