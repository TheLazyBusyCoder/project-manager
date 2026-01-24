<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleTesterModel extends Model
{
    protected $table = 'module_testers';

    public $timestamps = false;

    protected $fillable = [
        'module_id',
        'tester_id',
        'created_at',
    ];
}
