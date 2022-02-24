<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\DiamondController as APIDiamond;
use Illuminate\Http\Request;
use App\Http\Traits\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\Order;
use App\Mail\EmailVerification;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Elasticsearch\ClientBuilder;

class OrderController extends Controller
{
    use APIResponse;

    public function myOrders(Request $request)
    {
        $customer = Auth::user();
        $orders = DB::table('orders as o')
            // ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
            ->select('o.order_id', 'o.refPayment_mode_id', 'o.payment_mode_name', 'o.refTransaction_id', 'o.refCustomer_company_id_billing', 'o.billing_company_name', 'o.billing_company_office_no', 'o.billing_company_office_email', 'o.billing_company_office_address', 'o.billing_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_billing") as "billing_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_billing") as "billing_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_billing") as "billing_country"'), 'o.billing_company_pan_gst_no', 'o.refCustomer_company_id_shipping', 'o.shipping_company_name', 'o.shipping_company_office_no', 'o.shipping_company_office_email', 'o.shipping_company_office_address', 'o.shipping_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_shipping") as "shipping_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_shipping") as "shipping_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_shipping") as "shipping_country"'), 'o.shipping_company_pan_gst_no', 'o.sub_total', 'o.refDelivery_charge_id', 'o.delivery_charge_name', 'o.delivery_charge_amount', 'o.refDiscount_id', 'o.discount_name', 'o.discount_amount', 'o.refTax_id', 'o.tax_name', 'o.tax_amount', 'o.total_paid_amount', 'o.created_at', 'order_status')
            ->where('o.refCustomer_id', $customer->customer_id)
            ->orderBy('o.order_id', 'desc')
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

    public function myOrderDetails(Request $request, $transaction_id, $order_id)
    {
        try {
            $req = [
                'transaction_id' => $transaction_id,
                'order_id' => $order_id
            ];
            $rules = [
                'transaction_id' => ['required', 'integer'],
                'order_id' => ['required', 'integer']
            ];

            $message = [
                'transaction_id.required' => 'Invalid Request',
                'transaction_id.integer' => 'Invalid Request',
                'order_id.required' => 'Invalid Request',
                'order_id.integer' => 'Invalid Request'
            ];

            $validator = Validator::make($req, $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $customer = Auth::user();
            $orders = DB::table('orders as o')
                // ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
                ->join('order_diamonds as od', 'o.order_id', '=', 'od.refOrder_id')
                // ->join('categories as c', 'c.category_id', '=', 'od.refCategory_id')
                ->select('o.order_id', 'o.total_paid_amount', 'o.sub_total', 'o.discount_amount', 'o.tax_amount', 'o.delivery_charge_amount', 'o.refPayment_mode_id', 'o.payment_mode_name', 'o.refTransaction_id', 'o.refCustomer_company_id_billing', 'o.billing_company_name', 'o.billing_company_office_no', 'o.billing_company_office_email', 'o.billing_company_office_address', 'o.billing_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_billing") as "billing_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_billing") as "billing_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_billing") as "billing_country"'), 'o.billing_company_pan_gst_no', 'o.refCustomer_company_id_shipping', 'o.shipping_company_name', 'o.shipping_company_office_no', 'o.shipping_company_office_email', 'o.shipping_company_office_address', 'o.shipping_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_shipping") as "shipping_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_shipping") as "shipping_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_shipping") as "shipping_country"'), 'o.total_paid_amount', 'o.created_at', 'o.additional_discount', 'o.order_status', 'od.order_diamond_id', 'od.refDiamond_id', 'od.barcode', 'od.images', 'od.refCategory_id', 'od.name as diamond_name', 'od.price', 'od.expected_polish_cts')
                ->where('o.refCustomer_id', $customer->customer_id)
                ->where('o.order_id', $request->order_id)
                ->where('o.refTransaction_id', $request->transaction_id)
                ->get()
                ->toArray();
            if (count($orders) < 1) {
                return $this->errorResponse('No such order found');
            }

            $diamonds = DB::table('order_diamonds as od')
                ->join('categories as c', 'od.refCategory_id', '=', 'c.category_id')
                ->join('diamonds_attributes as da', 'od.refDiamond_id', '=', 'da.refDiamond_id')
                ->join('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
                ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
                ->select('od.price', 'od.barcode', 'od.rapaport_price', 'od.new_discount', 'od.refDiamond_id', 'od.expected_polish_cts', 'ag.name as ag_name', 'a.name as a_name', 'c.name as cat_name')
                ->where('od.refOrder_id', $request->order_id)
                ->whereIn('ag.name', ['COLOR', 'CLARITY', 'SHAPE'])
                ->get()
                ->toArray();

            $final_d = [];
            foreach ($diamonds as $v_row) {
                $final_d[$v_row->refDiamond_id]['attributes'][$v_row->{'ag_name'}] = $v_row->{'a_name'};
                $final_d[$v_row->refDiamond_id]['cat_name'] = $v_row->cat_name;
                $final_d[$v_row->refDiamond_id]['barcode'] = $v_row->barcode;
                $final_d[$v_row->refDiamond_id]['rapaport_price'] = $v_row->rapaport_price;
                $final_d[$v_row->refDiamond_id]['discount'] = $v_row->new_discount * 100;
                $final_d[$v_row->refDiamond_id]['total'] = $v_row->price;
                $final_d[$v_row->refDiamond_id]['expected_polish_cts'] = $v_row->expected_polish_cts;
            }

            $order_updates = DB::table('order_updates')
                ->where('refOrder_id', $request->order_id)
                ->orderby('order_update_id', 'ASC')
                ->get();

            foreach ($orders as $v) {
                $v->images = json_decode($v->images);
                // $a = [];
                // foreach ($v->images as $v1) {
                //     $a[] = '/storage/other_images/' . $v1;
                // }
                // $v->images = $a;
            }
            $data = ['orders' => $orders, 'diamonds' => array_values($final_d), 'status' => $order_updates];

            return $this->successResponse('Success', $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function saveMyOrder(Request $request)
    {
        try {
            $rules = [
                'billing_company_id' => ['required', 'integer'],
                'shipping_company_id' => ['required', 'integer']
            ];

            $message = [
                'shipping_company_id.required' => 'Please select shipping address',
                'shipping_company_id.integer' => 'Please select valid shipping address',
                'billing_company_id.required' => 'Please select billing address',
                'billing_company_id.integer' => 'Please select valid billing address'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $customer = Auth::user();

            $exists = DB::table('customer_company_details')
                ->select('customer_company_id')
                ->where('refCustomer_id', $customer->customer_id)
                ->where(function ($q) use ($request) {
                    $q->where('customer_company_id', $request->shipping_company_id)
                    ->orWhere('customer_company_id', $request->billing_company_id);
                })
                ->get();

            $diamonds = DB::table('customer_cart as c')
                ->join('diamonds as d', 'c.refDiamond_id', '=', 'd.diamond_id')
                ->select('d.diamond_id', 'd.barcode', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price', 'd.rapaport_price as mrp', 'd.refCategory_id', 'd.makable_cts', 'd.remarks', 'd.weight_loss', 'd.video_link', 'd.name', 'd.discount')
                ->where('d.available_pcs', '<>', 0)
                ->where('c.refCustomer_id', $customer->customer_id)
                ->get();
            if (count($diamonds) == 0) {
                return $this->errorResponse('Selected diamonds are currently out of stock...!');
            }

            $cart = new APIDiamond;
            $result = $cart->getCart();
            $cart_data = $result->original['data'];
            if (count($exists) < 1) {
                return $this->errorResponse('We are unable to find your selected address...!');
            } else if (!count($cart_data)) {
                return $this->errorResponse('Your cart is empty...!');
            }

            $subtotal = floatval(str_replace(',', '', $cart_data['summary']['subtotal']));
            $total = floatval(str_replace(',', '', $cart_data['summary']['total']));
            $weight = floatval(str_replace(',', '', $cart_data['summary']['weight']));
            $additional_discount = floatval(str_replace(',', '', $cart_data['summary']['additional_discount']));

            $shipping_info = collect($cart_data['all_company_details'])
                ->where('customer_company_id', $request->shipping_company_id)
                ->values()
                ->all();
            $billing_info = collect($cart_data['all_company_details'])
                ->where('customer_company_id', $request->billing_company_id)
                ->values()
                ->all();
            $discount = DB::table('discounts')
                ->select('discount_id', 'name', 'discount')
                ->where('from_amount', '<=', intval($subtotal))
                ->where('to_amount', '>=', intval($subtotal))
                ->first();
            $tax = DB::table('customer as c')
                ->join('customer_company_details as ccd', 'c.customer_id', '=', 'ccd.refCustomer_id')
                ->join('taxes as t', 'ccd.refCountry_id', '=', 't.refCountry_id')
                ->select('t.tax_id', 't.name', 't.amount')
                ->where('c.customer_id', $customer->customer_id)
                ->where('ccd.customer_company_id', $request->shipping_company_id)
                ->first();

            $shipping = DB::table('delivery_charges')
                ->select('delivery_charge_id', 'name', 'amount')
                ->where('from_weight', '<=', intval($weight))
                ->where('to_weight', '>=', (intval($weight) + 1))
                ->first();

            $order = new Order;
            $order->refCustomer_id = $customer->customer_id;
            $order->name = $customer->name;
            $order->mobile_no = $customer->mobile;
            $order->email_id = $customer->email;
            $order->refPayment_mode_id = 1;
            $order->payment_mode_name = 'COD';
            $order->refTransaction_id = mt_rand(111111, 999999);
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
            $order->sub_total = $subtotal;
            $order->refDelivery_charge_id = $shipping->delivery_charge_id ?? 0;
            $order->delivery_charge_name = $shipping->name ?? 0;
            $order->delivery_charge_amount = $shipping->amount ?? 0;
            $order->refDiscount_id = $discount->discount_id ?? 0;
            $order->discount_name = $discount->name ?? 0;
            $order->discount_amount = $discount->discount ?? 0;
            $order->refTax_id = $tax->tax_id ?? 0;
            $order->tax_name = $tax->name ?? 0;
            $order->tax_amount = $tax->amount ?? 0;
            $order->total_paid_amount = $total;
            $order->added_by = 0;
            $order->order_type = 1;
            $order->date_added = date('Y-m-d H:i:s');
            $order->date_updated = date('Y-m-d H:i:s');
            $order->due_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +7 days'));
            $order->additional_discount = $additional_discount ?? 0;
            $order->order_status = 'PENDING';
            $order->save();

            DB::table('order_updates')
            ->insert([
                'order_status_name' => 'PENDING',
                'refOrder_id' => $order->order_id,
                'comment' => 'Order has been placed by ' . $customer->name,
                'added_by' => 0,
                'is_deleted' => 0,
                'date_added' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            customer_activity('inserted', $customer->name . ' has placed an order (#' . $order->order_id . ')', '/admin/orders/view/' . $order->order_id);

            $od = $d_ids = [];
            $params = [];
            foreach ($diamonds as $v) {
                $params["body"][] = [
                    "delete" => [
                        "_index" => 'diamonds',
                        "_id" => 'd_id_' . $v->diamond_id,
                    ]
                ];
                $d_ids[] = $v->diamond_id;
                $od[] = [
                    'refOrder_id' => $order->order_id,
                    'refDiamond_id' => $v->diamond_id,
                    'name' => $v->name,
                    'price' => $v->price,
                    'barcode' => $v->barcode,
                    'makable_cts' => $v->makable_cts,
                    'expected_polish_cts' => $v->carat,
                    'remarks' => $v->remarks,
                    'rapaport_price' => $v->mrp,
                    'discount' => $v->discount,
                    'new_discount' => $v->discount,
                    'weight_loss' => $v->weight_loss,
                    'video_link' => $v->video_link,
                    'images' => $v->image,
                    'refCategory_id' => $v->refCategory_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
            $client = ClientBuilder::create()
                ->setHosts(['localhost:9200'])
                ->build();
            $elastic_params = [
                'index' => 'diamonds',
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                ['terms' => ['diamond_id' => $d_ids]],
                            ]
                        ]
                    ]
                ]
            ];
            $get_attributes = $client->search($elastic_params);
            // $get_shapes = $get_color = $get_carat = $get_clarity = $get_cut = [];
            foreach ($get_attributes['hits']['hits'] as $v) {
                $v = $v['_source'];
                DB::table('most_ordered_diamonds')
                    ->where('shape', $v['attributes']['SHAPE'])
                    ->where('refCategory_id', $v['refCategory_id'])
                    ->increment('shape_cnt', 1);

                DB::table('most_ordered_diamonds')
                    ->where('color', $v['attributes']['COLOR'])
                    ->where('refCategory_id', $v['refCategory_id'])
                    ->increment('color_cnt', 1);

                DB::table('most_ordered_diamonds')
                    ->where('clarity', $v['attributes']['CLARITY'])
                    ->where('refCategory_id', $v['refCategory_id'])
                    ->increment('clarity_cnt', 1);

                if ($v['refCategory_id'] != 1) {
                    DB::table('most_ordered_diamonds')
                        ->where('cut', $v['attributes']['CUT'])
                        ->where('refCategory_id', $v['refCategory_id'])
                        ->increment('cut_cnt', 1);
                }

                $mvd_exists = DB::table('most_ordered_diamonds')
                    ->where('carat', $v['expected_polish_cts'])
                    ->where('refCategory_id', $v['refCategory_id'])
                    ->first();
                if ($mvd_exists) {
                    DB::table('most_ordered_diamonds')
                        ->where('carat', $v['expected_polish_cts'])
                        ->where('refCategory_id', $v['refCategory_id'])
                        ->increment('carat_cnt', 1);
                } else {
                    DB::table('most_ordered_diamonds')
                    ->insert([
                        'refCategory_id' => $v['refCategory_id'],
                        'carat' => $v['expected_polish_cts'],
                        'shape_cnt' => 0,
                        'color_cnt' => 0,
                        'carat_cnt' => 1,
                        'clarity_cnt' => 0,
                        'cut_cnt' => 0,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ]);
                }
            }

            $client->bulk($params);

            // DB::table('diamonds')->whereIn('diamond_id', $d_ids)->decrement('available_pcs', 1);
            DB::table('diamonds')->whereIn('diamond_id', $d_ids)->update(['available_pcs' => 0]);

            DB::table('order_diamonds')->insert($od);

            DB::table('customer_cart')->where('refCustomer_id', $customer->customer_id)->delete();

            sendPushNotification('New Order Placed', $customer->name . ' has placed an order [#'. $order->order_id .'] for ' . count($d_ids) . ' diamonds', url('/admin/customers?filter=unapproved'));

            return $this->successResponse('Order placed successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}