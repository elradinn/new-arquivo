<?php

namespace Modules\NumberingScheme\Models;

use Modules\Folder\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NumberingScheme extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'folder_item_id',
        'name',
        'prefix',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
