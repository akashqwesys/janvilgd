<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapaport extends Model
{
    use HasFactory;
    protected $table='rapaport_type';
    protected $primaryKey = 'rapaport_type_id';
    protected $fillable = [
        'rapaport_type_id',  
        'name', 
        'rapaport_category',
        'date_added',
        'date_updated'
    ]; 
}
