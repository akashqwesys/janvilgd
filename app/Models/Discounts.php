<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discounts extends Model {

    use HasFactory;

    protected $table = 'discounts';
    protected $primaryKey = 'discount_id';
    protected $fillable = [
        'discount_id',
        'name',
        'from_amount',
        'to_amount',
        'discount',
        'added_by',
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];

}
