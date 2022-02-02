<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customers extends Authenticatable
{
    use HasApiTokens, HasFactory;
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
        'date_updated',
        'otp',
        'otp_status',
        'verified_status',
        'is_approved',
        'approved_at',
        'approved_by'
    ];

    protected $protected = ['password'];
}
