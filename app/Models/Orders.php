<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table='orders';
    protected $primaryKey = 'order_id';
    protected $fillable = [
        'order_id',
        'refCustomer_id',
        'name',
        'mobile_no',
        'email_id',
        'refPayment_mode_id',
        'payment_mode_name',
        'refTransaction_id',

        'refCustomer_company_id_billing',
        'billing_company_name',
        'billing_company_office_no',
        'billing_company_office_email',
        'billing_company_office_address',
        'billing_company_office_pincode',
        'refCity_id_billing',
        'refState_id_billing',
        'refCountry_id_billing',
        'billing_company_pan_gst_no',

        'refCustomer_company_id_shipping',
        'shipping_company_name',
        'shipping_company_office_no',
        'shipping_company_office_email',
        'shipping_company_office_address',
        'shipping_company_office_pincode',
        'refCity_id_shipping',
        'refState_id_shipping',
        'refCountry_id_shipping',
        'shipping_company_pan_gst_no',

        'sub_total',
        'refDelivery_charge_id',
        'delivery_charge_name',
        'delivery_charge_amount',
        'refDiscount_id',
        'discount_name',
        'discount_amount',
        'refTax_id',
        'tax_name',
        'tax_amount',
        'total_paid_amount',
        'order_type',
        'added_by',
        'date_added',
        'date_updated',
        'attention',
        'billing_remarks',
        'shipping_remarks',
        'due_date'
    ];
}
