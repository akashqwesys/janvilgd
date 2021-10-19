<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformativePages extends Model {

    use HasFactory;

    protected $table = 'informative_pages';
    protected $primaryKey = 'informative_page_id';
    protected $fillable = [
        'informative_page_id',
        'name',
        'content',       
        'slug',
        'updated_by',
        'is_active',     
        'date_updated'
    ];

}
