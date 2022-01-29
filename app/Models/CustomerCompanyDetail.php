<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCompanyDetail extends Model
{
    use HasFactory;
    protected $table = 'customer_company_details';
    protected $primaryKey = 'customer_company_id';
    protected $fillable = [
        'customer_company_id',
        'refCustomer_id',
        'name',
        'office_no',
        'official_email',
        'refDesignation_id',
        'designation_name',
        'office_address',
        'pincode',
        'refCity_id',
        'refState_id',
        'refCountry_id',
        'pan_gst_no',
        'pan_gst_attachment',
        // 'is_approved',
        // 'approved_date_time',
        // 'approved_by',
        'company_id_type'
    ];
}
