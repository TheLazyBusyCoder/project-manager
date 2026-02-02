<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCommentsModel extends Model
{
    public $table = 'task_comments';
    public $guarded = [];

    public function user() {
        return $this->hasOne(User::class , 'id' , 'user_id');
    }
}
