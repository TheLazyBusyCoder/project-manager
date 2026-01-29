<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BugAttachmentModel extends Model
{
    protected $table = 'bug_attachments';

    protected $fillable = [
        'bug_id',
        'uploaded_by',
        'file_path',
        'file_type'
    ];
}
