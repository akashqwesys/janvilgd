<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    use HasFactory;
    protected $table = 'customer_type';
    protected $primaryKey = 'customer_type_id';
    protected $fillable = [
        'customer_type_id',
        'name',
        'discount',
        'allow_credit',
        'credit_limit',
        'added_by',
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];

}
