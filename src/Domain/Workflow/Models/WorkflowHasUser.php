<?php

namespace Domain\Workflow\Models;

use Domain\User\Models\User;
use Domain\Workflow\Models\Workflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkflowHasUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'workflow_id',
        'user_id',
        'user_state',
        'comment',
    ];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
