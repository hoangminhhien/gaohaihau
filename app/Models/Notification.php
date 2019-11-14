<?php

namespace App\Models;

use BaseModel;

class Notification extends BaseModel
{
    const DEFAULT = [
        'type' => 1,
        'object_type' => 'common'
    ];
    const IS_UNREAD = 0;
    const IS_READ = 1;

    protected $fillable = [
        'type',
        'from_id',
        'to_id',
        'title',
        'object_type',
        'is_read',
        'content',
        'data'
    ];
}
