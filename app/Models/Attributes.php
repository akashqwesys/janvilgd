<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;
    protected $table='attributes';
    protected $primaryKey = 'attribute_id';
    protected $fillable = [
        'attribute_id', 
        'name',
        'attribute_group_id',         
        'image',        
        'added_by',
        'is_active',
        'is_deleted' ,
        'date_added',
        'date_updated'
    ];  
}
