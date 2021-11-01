<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentlyViewDiamond extends Model
{
    use HasFactory;

    protected $fillable = [
        'refCustomer_id',
        'refDiamond_id',
        'refAttribute_group_id',
        'refAttribute_id'
    ];
}
