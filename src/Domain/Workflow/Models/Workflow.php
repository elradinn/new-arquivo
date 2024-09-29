<?php

namespace Domain\Workflow\Models;

use Domain\Folder\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'folder_id',
        'resolution',
        'destination',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    public function workflowUsers()
    {
        return $this->hasMany(WorkflowHasUser::class);
    }
}
