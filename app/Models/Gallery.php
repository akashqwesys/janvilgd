<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $primaryKey = 'gallery_id';

    protected $fillable = [
        'gallery_id',
        'title',
        'image',
        'added_by',
        'is_active',
        'is_deleted'
    ];
}
