<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $table='customer';
    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'customer_id',
        'name',
        'mobile',
        'email',
        'address',
        'pincode',
        'refCity_id',
        'refState_id',
        'refCountry_id',
        'refCustomerType_id',
        'restrict_transactions',
        'added_by',
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];
}
