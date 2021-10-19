<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model {

    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'event_id';
    protected $fillable = [
        'event_id',
        'title',
        'image',
        'video_link',
        'description',
        'slug',
        'added_by',
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];

}
