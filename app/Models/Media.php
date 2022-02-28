<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $primaryKey = 'media_id';

    protected $fillable = [
        'media_id',
        'title',
        'image',
        'video_link',
        'description',
        'slug',
        'added_by',
        'is_active',
        'is_deleted'
    ];
}
