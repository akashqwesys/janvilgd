<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table='city';
    protected $primaryKey = 'city_id';
    protected $fillable = [
        'city_id',  
        'name',
        'refState_id',
        'added_by',
        'is_active',
        'is_deleted' ,
        'date_added',
        'date_updated'
    ]; 
}
