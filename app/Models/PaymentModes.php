<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModes extends Model
{
    use HasFactory;
    
    protected $table = 'payment_modes';
    protected $primaryKey = 'payment_mode_id';
    protected $fillable = [
        'payment_mode_id',
        'name',
        'sort_order',        
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];
}
