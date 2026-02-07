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

    public function comments()
    {
        return $this->hasMany(BugCommentModel::class, 'bug_id');
    }

    public function attachments()
    {
        return $this->hasMany(BugAttachmentModel::class, 'bug_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
