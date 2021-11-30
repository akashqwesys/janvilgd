<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;
// use Illuminate\Http\Request;
// use ElasticScoutDriverPlus\Searchable;

class Diamonds extends Model
{
    use HasFactory/* , Searchable */;

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
        'image',
        'refCategory_id',
        'added_by',
        'is_active',
        'is_deleted',
        'date_added',
        'date_updated'
    ];

    /* public function toSearchableArray()
    {
        return [
            'diamond_id' => $this->diamond_id,
            'name' => $this->name,
            'barcode' => $this->barcode,
            'packate_no' => $this->packate_no,
            'actual_pcs' => $this->actual_pcs,
            'available_pcs' => $this->available_pcs,
            'makable_cts' => $this->makable_cts,
            'expected_polish_cts' => $this->expected_polish_cts,
            'remarks' => $this->remarks,
            'rapaport_price' => $this->rapaport_price,
            'discount' => $this->discount,
            'weight_loss' => $this->weight_loss,
            'video_link' => $this->video_link,
            'image' => $this->image,
            'refCategory_id' => $this->refCategory_id,
            'added_by' => $this->added_by,
            'is_active' => $this->is_active,
            'is_deleted' => $this->is_deleted,
            'date_added' => $this->date_added,
            'date_updated' => $this->date_updated
        ];
    } */
}
