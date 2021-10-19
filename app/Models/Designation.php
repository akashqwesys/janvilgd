<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $table='designation';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'added_by',
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];    
}
