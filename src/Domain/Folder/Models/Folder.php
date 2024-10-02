<?php

namespace Domain\Folder\Models;

use Domain\Item\Models\Item;
use Domain\NumberingScheme\Models\NumberingScheme;
use Domain\Workflow\Models\Workflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

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
}
