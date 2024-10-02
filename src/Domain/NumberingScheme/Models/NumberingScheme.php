<?php

namespace Domain\NumberingScheme\Models;

use Domain\Folder\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NumberingScheme extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'folder_item_id',
        'prefix',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
