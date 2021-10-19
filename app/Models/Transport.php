<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;
    
    protected $table = 'transport';
    protected $primaryKey = 'transport_id';
    protected $fillable = [
        'transport_id',
        'name',
        'added_by',        
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];
}
