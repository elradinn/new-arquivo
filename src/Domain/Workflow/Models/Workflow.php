<?php

namespace Domain\Workflow\Models;

use Domain\Folder\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'folder_item_id',
        'resolution',
        'destination',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function workflowUsers()
    {
        return $this->hasMany(WorkflowHasUser::class);
    }
}
