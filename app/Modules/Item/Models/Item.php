<?php

namespace Modules\Item\Models;

use Modules\Document\Models\Document;
use Modules\Folder\Models\Folder;
use Modules\Workspace\Models\Workspace;
use Franzose\ClosureTable\Models\Entity;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Item extends Entity
{
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * ClosureTable model instance.
     *
     * @var Modules\Item\Models\ItemClosure
     */
    protected $closure = 'Modules\Item\Models\ItemClosure';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'position',
    ];

    public function workspace(): HasOne
    {
        return $this->hasOne(Workspace::class);
    }

    public function folder(): HasOne
    {
        return $this->hasOne(Folder::class, 'item_id');
    }

    public function document(): HasOne
    {
        return $this->hasOne(Document::class, 'item_id');
    }
}
