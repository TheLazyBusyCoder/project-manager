<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BugAttachmentModel extends Model
{
    protected $table = 'bug_attachments';

    protected $guarded = [];

    public $timestamps = false;

    public function bug()
    {
        return $this->belongsTo(BugModel::class, 'bug_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

}
