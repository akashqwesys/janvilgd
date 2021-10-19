<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $table='state';
    protected $primaryKey = 'state_id';
    protected $fillable = [
        'state_id',  
        'name',
        'refCountry_id',
        'added_by',
        'is_active',
        'is_deleted' ,
        'date_added',
        'date_updated'
    ]; 
}
