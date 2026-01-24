<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'project_id',
        'module_id',
        'assigned_to',
        'created_by',
        'title',
        'description',
        'priority',
        'status',
        'estimated_hours',
        'actual_hours',
        'due_date',
    ];
}
