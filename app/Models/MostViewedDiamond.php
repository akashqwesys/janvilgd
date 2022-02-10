<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MostViewedDiamond extends Model
{
    use HasFactory;

    protected $fillable = [
        'refCategory_id', 'views_cnt'
    ];
}
