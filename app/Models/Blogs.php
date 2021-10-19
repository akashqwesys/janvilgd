<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;
    protected $table='blogs';
    protected $primaryKey = 'blog_id';
    protected $fillable = [
        'blog_id',  
        'title',
        'image',
        'video_link',
        'description',
        'slug',
        'added_by',
        'is_active',
        'is_deleted' ,
        'date_added',
        'date_updated'
    ];    
}
