<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxes extends Model
{
    use HasFactory;
    protected $table = 'taxes';
    protected $primaryKey = 'tax_id';
    protected $fillable = [
        'tax_id',
        'name',
        'amount',
        'refCity_id',
        'refState_id',
        'refCountry_id',
        'added_by',        
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];
}
