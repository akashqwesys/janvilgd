<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Modules extends Model
{
    use HasFactory;
    protected $table='modules';
    protected $primaryKey = 'module_id';
    protected $fillable = [
        'module_id',
        'name',
        'icon',
        'slug',
        'parent_id',
        'added_by',
        'is_active',
        'is_deleted' ,
        'date_added',
        'date_updated',
        'sort_order',
        'menu_level'
    ];
}
