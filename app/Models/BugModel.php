<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BugModel extends Model
{
    protected $table = 'bugs';

    protected $fillable = [
        'project_id',
        'module_id',
        'reported_by',
        'assigned_to',
        'title',
        'description',
        'severity',
        'status',
        'steps_to_reproduce',
    ];
}
