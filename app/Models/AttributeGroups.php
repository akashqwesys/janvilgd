<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeGroups extends Model
{
    use HasFactory;
    
    protected $table = 'attribute_groups';
    protected $primaryKey = 'attribute_group_id';
    protected $fillable = [
        'attribute_group_id',
        'name',
        'image_required',
        'field_type',       
        'refCategory_id',
        'is_required',
        'added_by',
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];
}
