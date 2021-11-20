<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\Order;
use App\Models\CustomerCompanyDetail;
use App\Http\Controllers\API\DiamondController as APIDiamond;
use App\Http\Controllers\API\OrderController as APIOrder;
use DB;
use Carbon\Carbon;

class OrderController extends Controller {

    public function placeOrder(Request $request)
    {
        $customer = Auth::user();
        $tk = $request->token;
        $token = explode('---', base64_decode($request->token));
        $exists = DB::table('customer_company_details')
            ->select('customer_company_id')
            ->where('refCustomer_id', $customer->customer_id)
            ->where(function($q) use($token) {
                $q->where('customer_company_id', $token[0])
                ->orWhere('customer_company_id', $token[1]);
            })
            ->get();
        $cart = new APIDiamond;
        $result = $cart->getCart();
        if (count($exists) < 2 && !count($result->original['data'])) {
            return redirect()->back();
        }
        $title = 'Place Order';
        return view('front.orders.place_order', compact('title', 'tk'));
    }

    public function saveOrder(Request $request)
    {
        $customer = Auth::user();
        $token = explode('---', base64_decode($request->token));
        $exists = DB::table('customer_company_details')
            ->select('customer_company_id')
            ->where('refCustomer_id', $customer->customer_id)
            ->where(function ($q) use ($token) {
                $q->where('customer_company_id', $token[0])
                ->orWhere('customer_company_id', $token[1]);
            })
            ->get();
        $cart = new APIDiamond;
        $result = $cart->getCart();
        $cart_data = $result->original['data'];
        if (count($exists) < 2 && !count($cart_data)) {
            return redirect()->back();
        }

        $shipping_info = collect($cart_data['all_company_details'])
            ->where('customer_company_id', $token[0])
            ->values()
            ->all();
        $billing_info = collect($cart_data['all_company_details'])
            ->where('customer_company_id', $token[1])
            ->values()
            ->all();
        $discount = DB::table('discounts')
            ->select('discount_id', 'name', 'discount')
            ->where('from_amount', '<=', intval($cart_data['summary']['subtotal']))
            ->where('to_amount', '>=', intval($cart_data['summary']['subtotal']))
            ->first();
        $tax = DB::table('customer as c')
            ->join('customer_company_details as ccd', 'c.customer_id', '=', 'ccd.refCustomer_id')
            ->join('taxes as t', 'ccd.refCountry_id', '=', 't.refCountry_id')
            ->select('t.tax_id', 't.name', 't.amount')
            ->where('c.customer_id', $customer->customer_id)
            ->first();
        $shipping = DB::table('delivery_charges')
            ->select('delivery_charge_id', 'name', 'amount')
            ->where('from_weight', '<=', (intval($cart_data['summary']['weight']) - 1))
            ->where('to_weight', '>=', (intval($cart_data['summary']['weight']) + 1))
            ->first();

        $order = new Order;
        $order->refCustomer_id = $customer->customer_id;
        $order->name = $customer->name;
        $order->mobile_no = $customer->mobile;
        $order->email_id = $customer->email;
        $order->refPayment_mode_id = 1;
        $order->payment_mode_name = 'COD';
        $order->refTransaction_id = mt_rand(1111, 9999);
        $order->refCustomer_company_id_billing = $billing_info[0]->customer_company_id;
        $order->billing_company_name = $billing_info[0]->name;
        $order->billing_company_office_no = $billing_info[0]->office_no;
        $order->billing_company_office_email = $billing_info[0]->official_email;
        $order->billing_company_office_address = $billing_info[0]->office_address;
        $order->billing_company_office_pincode = $billing_info[0]->pincode;
        $order->refCity_id_billing = $billing_info[0]->refCity_id;
        $order->refState_id_billing = $billing_info[0]->refState_id;
        $order->refCountry_id_billing = $billing_info[0]->refCountry_id;
        $order->billing_company_pan_gst_no = $billing_info[0]->pan_gst_no;
        $order->refCustomer_company_id_shipping = $shipping_info[0]->customer_company_id;
        $order->shipping_company_name = $shipping_info[0]->name;
        $order->shipping_company_office_no = $shipping_info[0]->office_no;
        $order->shipping_company_office_email = $shipping_info[0]->official_email;
        $order->shipping_company_office_address = $shipping_info[0]->office_address;
        $order->shipping_company_office_pincode = $shipping_info[0]->pincode;
        $order->refCity_id_shipping = $shipping_info[0]->refCity_id;
        $order->refState_id_shipping = $shipping_info[0]->refState_id;
        $order->refCountry_id_shipping = $shipping_info[0]->refCountry_id;
        $order->shipping_company_pan_gst_no = $shipping_info[0]->pan_gst_no;
        $order->sub_total = $cart_data['summary']['subtotal'];
        $order->refDelivery_charge_id = $shipping->delivery_charge_id ?? 0;
        $order->delivery_charge_name = $shipping->name ?? 0;
        $order->delivery_charge_amount = $shipping->amount ?? 0;
        $order->refDiscount_id = $discount->discount_id ?? 0;
        $order->discount_name = $discount->name ?? 0;
        $order->discount_amount = $discount->discount ?? 0;
        $order->refTax_id = $tax->tax_id ?? 0;
        $order->tax_name = $tax->name ?? 0;
        $order->tax_amount = $tax->amount ?? 0;
        $order->total_paid_amount = $cart_data['summary']['total'];
        $order->added_by = 0;
        $order->date_added = date('Y-m-d H:i:s');
        $order->date_updated = date('Y-m-d H:i:s');
        $order->save();

        DB::table('order_updates')
        ->insert([
            'order_status_name' => 'PENDING',
            'refOrder_id' => $order->order_id,
            'comment' => 'comment',
            'added_by' => 0,
            'is_deleted' => 0,
            'date_added' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $diamonds = DB::table('customer_cart as c')
            ->join('diamonds as d', 'c.refDiamond_id', '=', 'd.diamond_id')
            ->select('d.diamond_id', 'd.barcode', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price', 'd.rapaport_price as mrp', 'd.refCategory_id', 'd.makable_cts', 'd.remarks', 'd.weight_loss', 'd.video_link', 'd.name')
            ->where('c.refCustomer_id', $customer->customer_id)
            ->get();
        $od = [];
        foreach ($diamonds as $v) {
            $od[] = [
                'refOrder_id' => $order->order_id,
                'refDiamond_id' => $v->diamond_id,
                'name' => $v->name,
                'barcode' => $v->barcode,
                'makable_cts' => $v->makable_cts,
                'expected_polish_cts' => $v->carat,
                'remarks' => $v->remarks,
                'rapaport_price' => $v->mrp,
                'discount' => 0,
                'weight_loss' => $v->weight_loss,
                'video_link' => $v->video_link,
                'images' => $v->image,
                'refCategory_id' => $v->refCategory_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        DB::table('order_diamonds')->insert($od);

        DB::table('customer_cart')->where('refCustomer_id', $customer->customer_id)->delete();

        return redirect('/customer/my-orders');
    }

    public function getMyOrders(Request $request)
    {
        $api = new APIOrder;
        $data = $api->myOrders($request);
        $orders = $data->original['data']['orders'];
        $title = 'My Orders';
        return view('front.orders.my_orders', compact('title', 'orders'));
    }

    public function orderDetails(Request $request)
    {
        $api = new APIOrder;
        $data = $api->myOrderDetails($request);
        $orders = $data->original['data']['orders'];
        $title = 'Order Details';
        return view('front.orders.my_orders', compact('title', 'orders'));
    }
}