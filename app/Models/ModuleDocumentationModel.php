<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleDocumentationModel extends Model
{
    protected $table = 'module_documentations';

    protected $fillable = [
        'module_id',
        'written_by',
        'title',
        'content',
        'version',
        'created_at',
        'updated_at'
    ];
}