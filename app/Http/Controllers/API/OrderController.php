<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\CustomerCompanyDetail;
use App\Mail\EmailVerification;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    use APIResponse;

    public function myOrders(Request $request)
    {
        $customer = Auth::user();
        $orders = DB::table('orders as o')
            ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
            ->select('o.order_id', 'o.refPayment_mode_id', 'o.payment_mode_name', 'o.refTransaction_id', 'o.refCustomer_company_id_billing', 'o.billing_company_name', 'o.billing_company_office_no', 'o.billing_company_office_email', 'o.billing_company_office_address', 'o.billing_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_billing") as "billing_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_billing") as "billing_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_billing") as "billing_country"'), 'o.billing_company_pan_gst_no', 'o.refCustomer_company_id_shipping', 'o.shipping_company_name', 'o.shipping_company_office_no', 'o.shipping_company_office_email', 'o.shipping_company_office_address', 'o.shipping_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_shipping") as "shipping_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_shipping") as "shipping_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_shipping") as "shipping_country"'), 'o.shipping_company_pan_gst_no', 'o.sub_total', 'o.refDelivery_charge_id', 'o.delivery_charge_name', 'o.delivery_charge_amount', 'o.refDiscount_id', 'o.discount_name', 'o.discount_amount', 'o.refTax_id', 'o.tax_name', 'o.tax_amount', 'o.total_paid_amount', 'o.created_at', 'ou.order_status_name')
            ->where('o.refCustomer_id', $customer->customer_id)
            ->get();
        /* foreach ($orders as $v) {
            $v->images = json_decode($v->images);
            $a = [];
            foreach ($v->images as $v1) {
                $a[] = '/storage/other_images/' . $v1;
            }
            $v->images = $a;
        } */
        $data = ['orders' => $orders];

        return $this->successResponse('Success', $data);
    }

    public function myOrderDetails(Request $request)
    {
        $customer = Auth::user();
        $orders = DB::table('orders as o')
            ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
            ->join('order_diamonds as od', 'o.order_id', '=', 'od.refOrder_id')
            // ->join('categories as c', 'c.category_id', '=', 'od.refCategory_id')
            ->select('o.order_id', 'o.refPayment_mode_id', 'o.payment_mode_name', 'o.refTransaction_id', 'o.refCustomer_company_id_billing', 'o.billing_company_name', 'o.billing_company_office_no', 'o.billing_company_office_email', 'o.billing_company_office_address', 'o.billing_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_billing") as "billing_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_billing") as "billing_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_billing") as "billing_country"'), 'o.billing_company_pan_gst_no', 'o.refCustomer_company_id_shipping', 'o.shipping_company_name', 'o.shipping_company_office_no', 'o.shipping_company_office_email', 'o.shipping_company_office_address', 'o.shipping_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_shipping") as "shipping_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_shipping") as "shipping_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_shipping") as "shipping_country"'), 'o.total_paid_amount', 'o.created_at', 'ou.order_status_name', 'od.order_diamond_id', 'od.refDiamond_id', 'od.barcode', 'od.images', 'od.refCategory_id', 'od.name as diamond_name', 'od.price')
            ->where('o.refCustomer_id', $customer->customer_id)
            ->get()
            ->toArray();

        foreach ($orders as $v) {
            $v->images = json_decode($v->images);
            $a = [];
            foreach ($v->images as $v1) {
                $a[] = '/storage/other_images/' . $v1;
            }
            $v->images = $a;
        }
        $data = ['orders' => $orders];

        return $this->successResponse('Success', $data);
    }
}