<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model {

    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_id',
        'name',
        'image',
        'description',
        'slug',
        'added_by',
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];

}
