<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectModel;

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

    public function parent()
    {
        return $this->belongsTo(ProjectModel::class, 'parent_module_id');
    }

    public function children()
    {
        return $this->hasMany(ModuleModel::class, 'parent_module_id')
                    ->with('children')
                    ->orderBy('created_at');
    }

    public function parentModule()
    {
        return $this->belongsTo(ModuleModel::class, 'parent_module_id');
    }

    public function documentation() {
        return $this->hasOne(ModuleDocumentationModel::class , 'module_id', 'id');
    }

    public function bugs()
    {
        return $this->hasMany(BugModel::class, 'module_id');
    }


}
