<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapaportcsv extends Model
{
    use HasFactory;
    protected $table='rapaport';
    protected $primaryKey = 'rapaport_id';
    protected $fillable = [
        'rapaport_id',  
        'shape', 
        'clarity',
        'color',
        'from_range',
        'to_range',
        'rapaport_price',
        'refRapaport_type_id'
    ]; 
}
