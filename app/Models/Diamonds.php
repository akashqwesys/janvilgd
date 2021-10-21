<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diamonds extends Model
{
    use HasFactory;
    protected $table='diamonds';
    protected $primaryKey = 'diamond_id';
    protected $fillable = [
        'diamond_id',  
        'name',
        'barcode',
        'packate_no',
        'actual_pcs',
        'available_pcs',
        'makable_cts',
        'expected_polish_cts',
        'remarks',
        'rapaport_price',
        'discount',
        'weight_loss',
        'video_link',
        'images',
        'refCategory_id',        
        'added_by',
        'is_active',
        'is_deleted' ,
        'date_added',
        'date_updated'
    ];
}
