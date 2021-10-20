<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCharges extends Model
{
    use HasFactory;
    protected $table='delivery_charges';
    protected $primaryKey = 'delivery_charge_id';
    protected $fillable = [
        'delivery_charge_id',  
        'name',
        'reftransport_id',
        'transport_name',
        'from_weight',
        'to_weight',
        'amount',
        'added_by',
        'is_active',
        'is_deleted' ,
        'date_added',
        'date_updated'
    ]; 
}
