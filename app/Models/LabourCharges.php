<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabourCharges extends Model
{
    use HasFactory;
    
    protected $table = 'labour_charges';
    protected $primaryKey = 'labour_charge_id';
    protected $fillable = [
        'labour_charge_id',
        'name',
        'amount', 
        'added_by',
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];
}
