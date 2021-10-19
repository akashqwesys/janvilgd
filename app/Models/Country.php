<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table='country';
    protected $primaryKey = 'country_id';
    protected $fillable = [
        'country_id',  
        'name',        
        'added_by',
        'is_active',
        'is_deleted' ,
        'date_added',
        'date_updated'
    ]; 
}
