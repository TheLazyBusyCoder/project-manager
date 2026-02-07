<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BugCommentModel extends Model
{
    protected $table = 'bug_comments';

    public $timestamps = false;

    protected $fillable = [
        'bug_id',
        'user_id',
        'comment',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
