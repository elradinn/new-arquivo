<?php

namespace Domain\Item\Models;

use Domain\Document\Models\Document;
use Domain\Folder\Models\Folder;
use Domain\Workspace\Models\Workspace;
use Franzose\ClosureTable\Models\Entity;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Entity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * ClosureTable model instance.
     *
     * @var Domain\Item\Models\ItemClosure
     */
    protected $closure = 'Domain\Item\Models\ItemClosure';

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
