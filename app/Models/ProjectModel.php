<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'project_manager_id',
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
    ];
}
