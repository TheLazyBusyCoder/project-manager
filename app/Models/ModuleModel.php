<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'project_id',
        'parent_module_id',
        'name',
        'description',
        'status',
    ];
}
