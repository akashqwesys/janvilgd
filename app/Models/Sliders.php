<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    use HasFactory;
    
    protected $table = 'sliders';
    protected $primaryKey = 'slider_id';
    protected $fillable = [
        'slider_id',
        'title',
        'image',
        'video_link',       
        'refCategory_id',
        'added_by',
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];
}
