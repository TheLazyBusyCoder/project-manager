<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function assignedUser() {
        return $this->hasOne(User::class , 'id' , 'assigned_to');
    }

    public function taskComments() {
        return $this->hasMany(TaskCommentsModel::class , 'id' , 'task_id');
    }
}
