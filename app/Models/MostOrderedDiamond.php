<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MostOrderedDiamond extends Model
{
    use HasFactory;

    protected $fillable = [
        'refCategory_id', 'shape', 'color', 'carat', 'clarity', 'cut', 'shape_cnt', 'color_cnt', 'carat_cnt', 'clarity_cnt', 'cut_cnt'
    ];
}
