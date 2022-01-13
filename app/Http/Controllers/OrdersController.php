<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Order;
use DataTables;
use Excel;
use App\Imports\DiamondsImport;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'List-Orders';
        $customers = DB::table('customer')
            ->select('customer_id', 'email', 'mobile', 'name')
            ->orderBy('customer_id', 'desc')
            ->get();
        $order_status = DB::table('order_statuses')
            ->select('order_status_id', 'name')
            ->orderby('sort_order', 'asc')
            ->get();
        return view('admin.orders.list', ["data" => $data, 'request' => $request, 'customers' => $customers, 'order_status' => $order_status]);
    }

    public function customerAddress (Request $request)
    {
        if($request->refCustomer_id){
            $address_list = DB::table('customer_company_details')
            ->select('customer_company_details.*', 'city.name as city_name', 'state.name as state_name', 'country.name as country_name')
            ->join('city', 'city.city_id', '=', 'customer_company_details.refCity_id')
            ->join('state', 'state.state_id', '=', 'customer_company_details.refState_id')
            ->join('country', 'country.country_id', '=', 'customer_company_details.refCountry_id')
            ->where('refCustomer_id', $request->refCustomer_id)->get();
            echo json_encode($address_list);
        }
    }

    public function addExcel()
    {
        $customer = DB::table('customer')->where('is_active', 1)->where('is_deleted', 0)->orderBy('customer_id', 'asc')->get();
        $payment_modes = DB::table('payment_modes')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['customer'] = $customer;
        $data['payment_modes'] = $payment_modes;
        $data['title'] = 'Add-Order';
        return view('admin.orders.import', ["data" => $data]);
    }

    public function csvOrder(Request $request)
    {
        $res = Excel::toArray(new DiamondsImport, request()->file('file'));

        if (count($res)) {
            $barcode_array = [];
            $unique_array = [];
            foreach($res[0] as $element) {
                $hash = $element['barcode'];
                $unique_array[$hash] = $element;
            }
            $result = array_values($unique_array);

            foreach($unique_array as $row){
                array_push($barcode_array, $row['barcode']);
            }

            /* $labour_charge_4p = DB::table('labour_charges')
                ->where('is_active', 1)
                ->where('labour_charge_id', 1)
                ->where('is_deleted', 0)
                ->first();

            $labour_charge_rough = DB::table('labour_charges')
                ->where('is_active', 1)
                ->where('labour_charge_id', 2)
                ->where('is_deleted', 0)
                ->first(); */

            $customer = DB::table('customer')
                ->where('is_active', 1)
                ->where('is_deleted', 0)
                ->where('customer_id', $request->refCustomer_id)
                ->first();

            $shipping_address = DB::table('customer_company_details')
                ->where('customer_company_id', $request->refCustomer_company_id_shipping)
                ->first();

            $billing_address = DB::table('customer_company_details')
                ->where('customer_company_id', $request->refCustomer_company_id_billing)
                ->first();

            $payment_mode = DB::table('payment_modes')
                ->where('is_active', 1)
                ->where('is_deleted', 0)
                ->where('payment_mode_id', $request->payment_mode_id)
                ->first();

            $tax = DB::table('customer as c')
                ->join('customer_company_details as ccd', 'c.customer_id', '=', 'ccd.refCustomer_id')
                ->join('taxes as t', 'ccd.refCountry_id', '=', 't.refCountry_id')
                ->select('t.tax_id', 't.name', 't.amount')
                ->where('c.customer_id', $customer->customer_id)
                ->where('ccd.customer_company_id', $request->refCustomer_company_id_shipping)
                ->first();

            $diamonds = DB::table('diamonds')->select('diamonds.*','categories.category_type')
                ->join('categories', 'categories.category_id', '=', 'diamonds.refCategory_id')
                ->where('diamonds.is_active', 1)
                ->where('diamonds.is_deleted', 0)
                ->where('diamonds.available_pcs', '<>', 0)
                ->whereIn('diamonds.barcode', $barcode_array)
                ->get();

            if(count($diamonds)) {

                DB::table('orders')->insert([
                    'refCustomer_id' => $request->refCustomer_id,
                    'name' => $customer->name,
                    'mobile_no' => $customer->mobile,
                    'email_id' => $customer->email,
                    'refPayment_mode_id' => $payment_mode->payment_mode_id,
                    'payment_mode_name' => $payment_mode->name,
                    'refTransaction_id' => mt_rand(111111, 999999),

                    'refCustomer_company_id_billing' => $billing_address->customer_company_id,
                    'billing_company_name' => $billing_address->name,
                    'billing_company_office_no' => $billing_address->office_no,
                    'billing_company_office_email' => $billing_address->official_email,
                    'billing_company_office_address' => $billing_address->office_address,
                    'billing_company_office_pincode' => $billing_address->pincode,
                    'refCity_id_billing' => $billing_address->refCity_id,
                    'refState_id_billing' => $billing_address->refState_id,
                    'refCountry_id_billing' => $billing_address->refCountry_id,
                    'billing_company_pan_gst_no' => $billing_address->pan_gst_no,

                    'refCustomer_company_id_shipping' => $shipping_address->customer_company_id,
                    'shipping_company_name' => $shipping_address->name,
                    'shipping_company_office_no' => $shipping_address->office_no,
                    'shipping_company_office_email' => $shipping_address->official_email,
                    'shipping_company_office_address' => $shipping_address->office_address,
                    'shipping_company_office_pincode' => $shipping_address->pincode,
                    'refCity_id_shipping' => $shipping_address->refCity_id,
                    'refState_id_shipping' => $shipping_address->refState_id,
                    'refCountry_id_shipping' => $shipping_address->refCountry_id,
                    'shipping_company_pan_gst_no' => $shipping_address->pan_gst_no,

                    'refDelivery_charge_id' => 0,
                    'delivery_charge_name' => 0,
                    'delivery_charge_amount' => 0,
                    'refDiscount_id' => 0,
                    'discount_name' => 0,
                    'discount_amount' => 0,
                    'refTax_id' => $tax->tax_id ?? 0,
                    'tax_name' => $tax->name ?? 0,
                    'tax_amount' => $tax->amount ?? 0,
                    'added_by'=> $request->session()->get('loginId'),
                    'sub_total' => 0,
                    'total_paid_amount' => 0,
                    'order_type' => 0,
                    'date_added' => date("Y-m-d h:i:s"),
                    'date_updated' => date("Y-m-d h:i:s"),
                    'created_at' => date("Y-m-d h:i:s"),
                    'updated_at' => date("Y-m-d h:i:s")
                ]);
                $order_Id = DB::getPdo()->lastInsertId();

                if(!empty($order_Id)){
                    DB::table('order_updates')->insert([
                        'refOrder_id' => $order_Id,
                        'order_status_name' => "PAID",
                        'comment' => "No comment",
                        'is_deleted' => 0,
                        'added_by' => $request->session()->get('loginId'),
                        'date_added' => date("Y-m-d h:i:s"),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }

                $batch_data = array();
                $d_ids = $params = [];
                $subtotal = $weight = 0;
                foreach($diamonds as $row){
                    $batch_d = array();
                    foreach($unique_array as $u_array){
                        if($row->barcode == $u_array['barcode']){
                            $discount = str_replace('-', '', $u_array['discount']);
                            $discount = doubleval((100 - $discount) / 100);
                            /* if ($row->category_type == config('constant.CATEGORY_TYPE_4P')) {
                                $total = abs(($row->rapaport_price * $row->expected_polish_cts * $discount)) - ($labour_charge_4p->amount*$row->expected_polish_cts);
                            }
                            if ($row->category_type == config('constant.CATEGORY_TYPE_ROUGH')) {
                                $price = abs($row->rapaport_price*$discount);
                                $amount = abs($price*doubleval($row->expected_polish_cts));
                                $ro_amount = abs($amount/doubleval($row->makable_cts));
                                $final_price = $ro_amount-$labour_charge_rough->amount;
                                $total = abs($final_price*(doubleval($row->makable_cts)));
                            }
                            if ($row->category_type == config('constant.CATEGORY_TYPE_POLISH')) {
                                $total = abs($row->rapaport_price*$row->expected_polish_cts*$discount);
                            } */
                            $subtotal += $row->total;
                            $weight += $row->expected_polish_cts;
                            $batch_d['refOrder_id'] = $order_Id;
                            $batch_d['refDiamond_id'] = $row->diamond_id;
                            $batch_d['barcode'] = $row->barcode;
                            $batch_d['makable_cts'] = $row->makable_cts;
                            $batch_d['expected_polish_cts'] = $row->expected_polish_cts;
                            $batch_d['remarks'] = $row->remarks;
                            $batch_d['rapaport_price'] = $row->rapaport_price;
                            $batch_d['discount'] = doubleval((1 - $discount) * 100);
                            $batch_d['weight_loss'] = round($row->weight_loss, 2);
                            $batch_d['video_link'] = $row->video_link;
                            $batch_d['images'] = $row->image;
                            $batch_d['refCategory_id'] = $row->refCategory_id;
                            $batch_d['price'] = $row->total;
                            $batch_d['name'] = $row->name;
                            $batch_d['created_at'] = date("Y-m-d h:i:s");
                            $batch_d['updated_at'] = date("Y-m-d h:i:s");

                            $params["body"][] = [
                                "delete" => [
                                    "_index" => 'diamonds',
                                    "_id" => 'd_id_' . $row->diamond_id,
                                ]
                            ];
                            $d_ids[] = $row->diamond_id;
                        }
                    }
                    if(!empty($batch_d)){
                        array_push($batch_data, $batch_d);
                    }
                }
                if (!empty($batch_data)) {
                    $overall_discount = DB::table('discounts')
                        ->select('discount_id', 'name', 'discount')
                        ->where('from_amount', '<=', intval($subtotal))
                        ->where('to_amount', '>=', intval($subtotal))
                        ->first();
                    $shipping_charge = DB::table('delivery_charges')
                        ->select('delivery_charge_id', 'name', 'amount')
                        ->where('from_weight', '<=', intval($weight))
                        ->where('to_weight', '>=', (intval($weight) + 1))
                        ->first();
                    $additional_discount = DB::table('customer as c')
                        ->join('customer_type as ct', 'c.refCustomerType_id', '=', 'ct.customer_type_id')
                        ->select('ct.discount')
                        ->where('c.customer_id', $request->refCustomer_id)
                        ->pluck('discount')
                        ->first();

                    $final_overall_discount = isset($overall_discount->discount) ? ($overall_discount->discount * $subtotal / 100) : 0;
                    $final_additional_discount = isset($additional_discount) ? ($additional_discount * $subtotal / 100) : 0;
                    $final_tax = isset($tax->amount) ? ($tax->amount * $subtotal / 100) : 0;
                    $total = $subtotal - $final_overall_discount - $final_additional_discount + $final_tax + ($shipping_charge->amount ?? 0);

                    DB::table('orders')->where('order_id', $order_Id)->update([
                        'refDelivery_charge_id' => $shipping_charge->delivery_charge_id ?? 0,
                        'delivery_charge_name' => $shipping_charge->name ?? 0,
                        'delivery_charge_amount' => $shipping_charge->amount ?? 0,
                        'refDiscount_id' => $overall_discount->discount_id ?? 0,
                        'discount_name' => $overall_discount->name ?? 0,
                        'discount_amount' => $overall_discount->discount ?? 0,
                        'sub_total' => $subtotal,
                        'total_paid_amount' => $total
                    ]);

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
                                'created_at' => date("Y-m-d h:i:s"),
                                'updated_at' => date("Y-m-d h:i:s")
                            ]);
                        }
                    }
                    $client->bulk($params);

                    DB::table('diamonds')->whereIn('diamond_id', $d_ids)->decrement('available_pcs', 1);

                    DB::table('order_diamonds')->insert($batch_data);
                    activity($request, "inserted", 'orders', $order_Id);
                    successOrErrorMessage("Order added successfully", 'success');
                }
            } else {
                successOrErrorMessage("Imported diamonds are not available in the stock", 'error');
            }
        } else {
            successOrErrorMessage("Sheet is Empty", 'error');
        }
        return redirect('admin/orders');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('orders')
                ->select('orders.order_id', 'orders.name', 'orders.mobile_no', 'orders.email_id', 'orders.payment_mode_name', 'orders.refTransaction_id', 'orders.total_paid_amount', 'orders.date_added', 'orders.date_updated');
            if (isset($request->order_status) && !empty($request->order_status)) {
                if ($request->order_status == 'PENDING') {
                    $data = $data->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('order_updates as ou')
                            ->whereColumn('ou.refOrder_id', 'orders.order_id')
                            ->whereNotIn('ou.order_status_name', ['PAID', 'UNPAID', 'CANCELLED']);
                    });
                } else if ($request->order_status == 'PAID') {
                    $data = $data->join('order_updates as ou', 'orders.order_id', '=', 'ou.refOrder_id')
                        ->where('ou.order_status_name', 'PAID');
                } else if ($request->order_status == 'UNPAID') {
                    $data = $data->join('order_updates as ou', 'orders.order_id', '=', 'ou.refOrder_id')
                        ->where('ou.order_status_name', 'UNPAID');
                } else if ($request->order_status == 'CANCELLED') {
                    $data = $data->join('order_updates as ou', 'orders.order_id', '=', 'ou.refOrder_id')
                        ->where('ou.order_status_name', 'CANCELLED');
                } else {
                    $data = $data->where('orders.order_type', 0);
                }
            }
            if (isset($request->startDate) && !empty($request->startDate)) {
                if ($request->startDate != $request->endDate) {
                    $data = $data->whereRaw("DATE(orders.date_added) >= '".$request->startDate."' AND DATE(orders.date_added) <= '".$request->endDate."'");
                } else {
                    $data = $data->whereRaw("DATE(orders.date_added) = '".$request->startDate."'");
                }
            }
            if (isset($request->customer_id) && !empty($request->customer_id)) {
                $data = $data->where('orders.refCustomer_id', $request->customer_id);
            }
            if (isset($request->category) && !empty($request->category)) {
                if (isset($request->shape) && !empty($request->shape)) {
                    /* if ($request->category == 3) {
                        $attr_ids = DB::table('attributes')
                        ->select(
                            DB::raw("case when attribute_group_id = 18 and name = '$request->shape' then attribute_id end as shape_id"),
                            DB::raw("case when attribute_group_id = 17 and name = '$request->color' then attribute_id end as color_id"),
                            DB::raw("case when attribute_group_id = 16 and name = '$request->clarity' then attribute_id end as clarity_id"),
                            DB::raw("case when attribute_group_id = 24 and name = '$request->cut' then attribute_id end as cut_id"),
                        )
                        ->first();
                    }
                    $data = $data->whereExists(function ($query) use ($request) {
                        $query->select(DB::raw(1))
                            ->from('order_diamonds as od')
                            ->whereColumn('od.refOrder_id', 'orders.order_id')
                            ->join('diamonds_attributes as da', 'od.refDiamond_id', '=', 'da.refDiamond_id')
                            ->where('refAttribute_id', $attr_ids->shape_id)
                            ->where('od.refCategory_id', $request->category);
                    }); */
                } else {
                    $data = $data->whereExists(function ($query) use($request) {
                        $query->select(DB::raw(1))
                            ->from('order_diamonds as od')
                            ->whereColumn('od.refOrder_id', 'orders.order_id')
                            ->where('od.refCategory_id', $request->category);
                    });
                }
            }
            $data = $data->orderBy('orders.order_id', 'desc')
                ->get();

            $updates = DB::table('order_updates')
                ->select('refOrder_id')
                ->where('order_status_name', 'PAID')
                ->orWhere('order_status_name', 'CANCELLED')
                ->pluck('refOrder_id')
                ->toArray();

            return Datatables::of($data)
                ->addColumn('index', '')
                // ->editColumn('date_updated', function ($row) {
                //     return date_formate($row->date_updated);
                // })
                ->editColumn('date_added', function ($row) {
                    return date_formate($row->date_added);
                })
                ->addColumn('action', function ($row) use ($updates){
                    $actionBtn = '';
                    if (!in_array($row->order_id, $updates)) {
                        $actionBtn = '<a href="/admin/orders/edit/' . $row->order_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a>';
                    }
                    $actionBtn .= ' <a href="/admin/orders/view/' . $row->order_id . '" class="btn btn-xs btn-primary">&nbsp;<em class="icon ni ni-eye-fill"></em></a>';
                    return $actionBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function addOrderHistory(Request $request)
    {
        $exists = DB::table('order_updates')
            ->select('order_status_name')
            ->where('order_status_name', $request->order_status_name)
            ->first();
        if ($exists) {
            successOrErrorMessage("Cannot duplicate the order status", 'error');
        } else {
            if ($request->order_status_name == 'CANCELLED') {
                $client = ClientBuilder::create()
                ->setHosts(['localhost:9200'])
                ->build();
                $params = [
                        'index' => 'diamonds',
                        'id'    => 'd_id_' . $Id,
                        'body'  => [
                            'diamond_id' => $Id,
                            'name' => $name,
                            'barcode' => isset($request->barcode) ? $request->barcode : 0,
                            'barcode_search' => isset($request->barcode) ? $request->barcode : 0,
                            'packate_no' => isset($request->packate_no) ? $request->packate_no : 0,
                            'actual_pcs' => isset($request->actual_pcs) ? $request->actual_pcs : 0,
                            'available_pcs' => isset($request->available_pcs) ? $request->available_pcs : 0,
                            'makable_cts' => isset($request->makable_cts) ? number_format($request->makable_cts, 3, '.', '') : 0,
                            'expected_polish_cts' => isset($request->expected_polish_cts) ? number_format($request->expected_polish_cts, 2, '.', '') : 0,
                            'remarks' => isset($request->remarks) ? $request->remarks : 0,
                            'rapaport_price' => isset($request->rapaport_price) ? $request->rapaport_price : 0,
                            'discount' => isset($request->discount) ? ($request->discount / 100) : 0,
                            'weight_loss' => isset($request->weight_loss) ? $request->weight_loss : 0,
                            'video_link' => isset($request->video_link) ? $request->video_link : NULL,
                            'image' => $imgData,
                            'refCategory_id' => isset($request->refCategory_id) ? $request->refCategory_id : 0,
                            'price_ct' => $price_per_carat,
                            'total' => $total,
                            'added_by' => $request->session()->get('loginId'),
                            'is_recommended' => isset($request->is_recommended) ? $request->is_recommended : 0,
                            'is_active' => 1,
                            'is_deleted' => 0,
                            'date_added' => date("Y-m-d h:i:s"),
                            'date_updated' => date("Y-m-d h:i:s"),
                            'attributes' => $new_attributes,
                            'attributes_id' => array_values($new_attributes_id)
                        ]
                    ];
                $client->create($params);
            }
            DB::table('order_updates')->insert([
                'order_status_name' => $request->order_status_name,
                'refOrder_id' => $request->id,
                'comment' => $request->comment,
                'added_by' => $request->session()->get('loginId'),
                'is_deleted' => 0,
                'date_added' => date("Y-m-d h:i:s")
            ]);
            // $Id = DB::getPdo()->lastInsertId();
            activity($request, "updated", 'orders', $request->id);
            successOrErrorMessage("Data updated Successfully", 'success');
        }
        return redirect('admin/orders/edit/' . $request->id);
    }

    public function edit($id)
    {
        $updates = DB::table('order_updates')
            ->select('refOrder_id')
            ->where('refOrder_id', $id)
            ->whereRaw("(order_status_name = 'PAID' or order_status_name = 'CANCELLED')")
            ->pluck('refOrder_id')
            ->toArray();
        if (!empty($updates)) {
            return redirect('/admin/orders');
        }
        $diamonds = DB::table('order_diamonds as od')
            ->join('categories as c', 'od.refCategory_id', '=', 'c.category_id')
            ->join('diamonds_attributes as da', 'od.refDiamond_id', '=', 'da.refDiamond_id')
            ->join('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
            ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            ->select('od.*','ag.name as ag_name','a.name as a_name', 'c.name as cat_name')
            ->where('od.refOrder_id', $id)
            ->whereIn('ag.name', ['COLOR','CLARITY','SHAPE'])
            ->get()
            ->toArray();

        $final_d = [];
        foreach ($diamonds as $v_row) {
            // for ($i=0; $i < 2; $i++) {
            // }
            $final_d[$v_row->refDiamond_id]['attributes'][$v_row->{'ag_name'}] = $v_row->{'a_name'};
            $final_d[$v_row->refDiamond_id]['cat_name'] = $v_row->cat_name;
            $final_d[$v_row->refDiamond_id]['barcode'] = $v_row->barcode;
            $final_d[$v_row->refDiamond_id]['total'] = $v_row->price;
            $final_d[$v_row->refDiamond_id]['expected_polish_cts'] = $v_row->expected_polish_cts;
        }

        $order_sts = DB::table('order_statuses')->where('name', '<>', 'PENDING')->orderby('sort_order', 'asc')->get();
        $order_history = DB::table('order_updates')->where('refOrder_id', $id)->orderby('order_update_id', 'DESC')->get();
        $result = DB::table('orders')
            ->select('orders.*','city_billing.name as billing_city_name','state_billing.name as billing_state_name','country_billing.name as billing_country_name','city_shipping.name as shipping_city_name','state_shipping.name as shipping_state_name','country_shipping.name as shipping_country_name')
            ->join('city as city_billing', 'city_billing.city_id', '=', 'orders.refCity_id_billing')
            ->join('state as state_billing', 'state_billing.state_id', '=', 'orders.refState_id_billing')
            ->join('country as country_billing', 'country_billing.country_id', '=', 'orders.refCountry_id_billing')

            ->join('city as city_shipping', 'city_shipping.city_id', '=', 'orders.refCity_id_shipping')
            ->join('state as state_shipping', 'state_shipping.state_id', '=', 'orders.refState_id_shipping')
            ->join('country as country_shipping', 'country_shipping.country_id', '=', 'orders.refCountry_id_shipping')
            ->where('order_id', $id)
            ->first();

        $address_list = DB::table('customer_company_details')->select('customer_company_details.*', 'city.name as city_name', 'state.name as state_name', 'country.name as country_name')
            ->join('city', 'city.city_id', '=', 'customer_company_details.refCity_id')
            ->join('state', 'state.state_id', '=', 'customer_company_details.refState_id')
            ->join('country', 'country.country_id', '=', 'customer_company_details.refCountry_id')
            ->where('refCustomer_id', $result->refCustomer_id)->get();
        $data['title'] = 'Edit-Orders';
        $data['address_list'] = $address_list;
        $data['diamonds'] = $final_d;
        $data['order_sts'] = $order_sts;
        $data['order_history'] = $order_history;
        $data['result'] = $result;
        $data['admin_name'] = DB::table('users')->select('name')->where('id', session()->get('loginId'))->pluck('name')->first();
        return view('admin.orders.edit', ["data" => $data]);
    }

    public function view($id)
    {
        $diamonds = DB::table('order_diamonds as od')
            ->join('categories as c', 'od.refCategory_id', '=', 'c.category_id')
            ->join('diamonds_attributes as da', 'od.refDiamond_id', '=', 'da.refDiamond_id')
            ->join('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
            ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            ->select('od.*','ag.name as ag_name','a.name as a_name', 'c.name as cat_name')
            ->where('od.refOrder_id', $id)
            ->whereIn('ag.name', ['COLOR', 'CLARITY', 'SHAPE'])
            ->get()
            ->toArray();

        $final_d = [];
        foreach ($diamonds as $v_row) {
            $final_d[$v_row->refDiamond_id]['attributes'][$v_row->{'ag_name'}] = $v_row->{'a_name'};
            $final_d[$v_row->refDiamond_id]['cat_name'] = $v_row->cat_name;
            $final_d[$v_row->refDiamond_id]['barcode'] = $v_row->barcode;
            $final_d[$v_row->refDiamond_id]['total'] = $v_row->price;
            $final_d[$v_row->refDiamond_id]['expected_polish_cts'] = $v_row->expected_polish_cts;
        }

        $order_sts = DB::table('order_statuses')->orderby('sort_order', 'asc')->get();
        $order_history = DB::table('order_updates')->where('refOrder_id', $id)->orderby('order_update_id', 'DESC')->get();
        $result = DB::table('orders')
            ->select('orders.*','city_billing.name as billing_city_name','state_billing.name as billing_state_name','country_billing.name as billing_country_name','city_shipping.name as shipping_city_name','state_shipping.name as shipping_state_name','country_shipping.name as shipping_country_name')
            ->join('city as city_billing', 'city_billing.city_id', '=', 'orders.refCity_id_billing')
            ->join('state as state_billing', 'state_billing.state_id', '=', 'orders.refState_id_billing')
            ->join('country as country_billing', 'country_billing.country_id', '=', 'orders.refCountry_id_billing')
            ->join('city as city_shipping', 'city_shipping.city_id', '=', 'orders.refCity_id_shipping')
            ->join('state as state_shipping', 'state_shipping.state_id', '=', 'orders.refState_id_shipping')
            ->join('country as country_shipping', 'country_shipping.country_id', '=', 'orders.refCountry_id_shipping')
            ->where('order_id', $id)
            ->first();

        $address_list = DB::table('customer_company_details')
            ->select('customer_company_details.*', 'city.name as city_name', 'state.name as state_name', 'country.name as country_name')
            ->join('city', 'city.city_id', '=', 'customer_company_details.refCity_id')
            ->join('state', 'state.state_id', '=', 'customer_company_details.refState_id')
            ->join('country', 'country.country_id', '=', 'customer_company_details.refCountry_id')
            ->where('refCustomer_id', $result->refCustomer_id)
            ->get();
        $data['title'] = 'View-Orders';
        $data['address_list'] = $address_list;
        $data['diamonds'] = $final_d;
        $data['order_sts'] = $order_sts;
        $data['order_history'] = $order_history;
        $data['result'] = $result;
        return view('admin.orders.view', ["data" => $data]);
    }

    public function update(Request $request)
    {
        $shipping_address = DB::table('customer_company_details')->select('customer_company_details.*', 'city.name as city_name', 'state.name as state_name', 'country.name as country_name')
            ->join('city', 'city.city_id', '=', 'customer_company_details.refCity_id')
            ->join('state', 'state.state_id', '=', 'customer_company_details.refState_id')
            ->join('country', 'country.country_id', '=', 'customer_company_details.refCountry_id')
            ->where('customer_company_id', $request->refCustomer_company_id_shipping)->first();

        $billing_address = DB::table('customer_company_details')->select('customer_company_details.*', 'city.name as city_name', 'state.name as state_name', 'country.name as country_name')
            ->join('city', 'city.city_id', '=', 'customer_company_details.refCity_id')
            ->join('state', 'state.state_id', '=', 'customer_company_details.refState_id')
            ->join('country', 'country.country_id', '=', 'customer_company_details.refCountry_id')
            ->where('customer_company_id', $request->refCustomer_company_id_billing)->first();

        DB::table('orders')->where('order_id', $request->id)->update([
            'refCustomer_company_id_billing' => $billing_address->customer_company_id,
            'billing_company_name' => $billing_address->name,
            'billing_company_office_no' => $billing_address->office_no,
            'billing_company_office_email' => $billing_address->official_email,
            'billing_company_office_address' => $billing_address->office_address,
            'billing_company_office_pincode' => $billing_address->pincode,
            'refCity_id_billing' => $billing_address->refCity_id,
            'refState_id_billing' => $billing_address->refState_id,
            'refCountry_id_billing' => $billing_address->refCountry_id,
            'billing_company_pan_gst_no' => $billing_address->pan_gst_no,

            'refCustomer_company_id_shipping' => $shipping_address->customer_company_id,
            'shipping_company_name' => $shipping_address->name,
            'shipping_company_office_no' => $shipping_address->office_no,
            'shipping_company_office_email' => $shipping_address->official_email,
            'shipping_company_office_address' => $shipping_address->office_address,
            'shipping_company_office_pincode' => $shipping_address->pincode,
            'refCity_id_shipping' => $shipping_address->refCity_id,
            'refState_id_shipping' => $shipping_address->refState_id,
            'refCountry_id_shipping' => $shipping_address->refCountry_id,
            'shipping_company_pan_gst_no' => $shipping_address->pan_gst_no,
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        activity($request, "updated", 'orders', $request->id);
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/orders');
    }

    public function status(Request $request)
    {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_active' => $request['status'],
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            // $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            activity($request, "updated", $request['module'], $request['table_id']);
            return response()->json($data);
        }
    }

    public function getBarcodes(Request $request)
    {
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();
        $elastic_params = [
            'index' => 'diamonds',
            'size' => 50,
            'from' => $request['page'] ? ($request['page'] - 1) * 50 : 0,
            'body' => [
                'query' => [
                    'prefix' => ['barcode_search' => $request['q']]
                ],
                'fields' => ['barcode'],
                '_source' => false
            ]
        ];
        $get = $client->search($elastic_params);
        if (count($get['hits']['hits'])) {
            $data = [];
            foreach ($get['hits']['hits'] as $v) {
                $data[] = [
                    'id' => $v['fields']['barcode'][0],
                    'text' => $v['fields']['barcode'][0]
                ];
            }
            return response()->json(['items' => $data, 'total_count' => count($data)]);
        } else {
            return response()->json(['items' => []]);
        }
    }

    public function getDiamonds(Request $request)
    {
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();
        $elastic_params = [
            'index' => 'diamonds',
            'size' => 50,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['terms' => ['barcode' => $request['barcode']]],
                        ]
                    ]
                ]
            ]
        ];
        $get = $client->search($elastic_params);
        $data = $get['hits']['hits'];
        if (count($data) < 1) {
            $data = [
                'data' => null,
                'subtotal' => 0,
                'discount' => 0,
                'add_discount' => 0,
                'tax' => 0,
                'shipping_charge' => 0
            ];
            return response()->json(['data' => $data, 'success' => 1]);
        }
        $html = null;
        $subtotal = $weight = 0;
        foreach ($data as $d) {
            $html .= '<tr class="tr_products">
                <td>' . $d['_source']['barcode'] . '</td>
                <td>' . $d['_source']['attributes']['SHAPE'] . '</td>
                <td>' . $d['_source']['expected_polish_cts'] . '</td>
                <td>' . $d['_source']['attributes']['COLOR'] . '</td>
                <td>' . $d['_source']['attributes']['CLARITY'] . '</td>
                <td>' . ($d['_source']['attributes']['CUT'] ?? '-') . '</td>
                <td>$' . $d['_source']['rapaport_price'] . '</td>
                <td> <input type="number" value="' . $d['_source']['discount']*100 . '" min="0" max="100" class="newDiscount form-control" data-category="' . $d['_source']['refCategory_id'] . '" data-makable="' . $d['_source']['makable_cts'] . '"></td>
                <td align="right" class="price_td">$' . $d['_source']['total'] . '</td>
            </tr>';
            $subtotal += $d['_source']['total'];
            $weight += $d['_source']['expected_polish_cts'];
        }
        $tax = DB::table('customer as c')
            ->join('customer_company_details as ccd', 'c.customer_id', '=', 'ccd.refCustomer_id')
            ->join('taxes as t', 'ccd.refCountry_id', '=', 't.refCountry_id')
            ->select('t.tax_id', 't.name', 't.amount')
            ->where('c.customer_id', $request['customer_id'])
            ->where('ccd.customer_company_id', $request['shipping_id'])
            ->first();
        $overall_discount = DB::table('discounts')
            ->select('discount_id', 'name', 'discount')
            ->where('from_amount', '<=', intval($subtotal))
            ->where('to_amount', '>=', intval($subtotal))
            ->first();
        $shipping_charge = DB::table('delivery_charges')
            ->select('delivery_charge_id', 'name', 'amount')
            ->where('from_weight', '<=', intval($weight))
            ->where('to_weight', '>=', (intval($weight) + 1))
            ->first();
        $additional_discount = DB::table('customer as c')
            ->join('customer_type as ct', 'c.refCustomerType_id', '=', 'ct.customer_type_id')
            ->select('ct.discount')
            ->where('c.customer_id', $request['customer_id'])
            ->pluck('discount')
            ->first();

        $final_overall_discount = isset($overall_discount->discount) ? round($overall_discount->discount * $subtotal / 100, 2) : 0;
        $final_additional_discount = isset($additional_discount) ? round($additional_discount * $subtotal / 100, 2) : 0;
        $final_tax = isset($tax->amount) ? round($tax->amount * $subtotal / 100, 2) : 0;
        $total = $subtotal - $final_overall_discount - $final_additional_discount + $final_tax + ($shipping_charge->amount ?? 0);
        $data = [
            'data' => trim($html),
            'subtotal' => round($subtotal, 2),
            'discount' => $final_overall_discount,
            'add_discount' => $final_additional_discount,
            'tax' => $final_tax,
            'shipping_charge' => $shipping_charge->amount ?? 0,
            'total' => round($total, 2)
        ];
        return response()->json(['data' => $data, 'success' => 1]);
    }

    public function getUpdatedTax(Request $request)
    {
        $tax = DB::table('customer as c')
            ->join('customer_company_details as ccd', 'c.customer_id', '=', 'ccd.refCustomer_id')
            ->join('taxes as t', 'ccd.refCountry_id', '=', 't.refCountry_id')
            ->select('t.tax_id', 't.name', 't.amount')
            ->where('c.customer_id', $request['customer_id'])
            ->where('ccd.customer_company_id', $request['shipping_id'])
            ->first();
        if ($tax) {
            return response()->json(['success' => 1, 'tax' => $tax->amount]);
        } else {
            return response()->json(['success' => 1, 'tax' => 0]);
        }
    }

    public function createInvoice(Request $request)
    {
        $data['title'] = 'Create Invoice';
        $order_id = DB::table('orders')->select('order_id')->orderBy('order_id', 'desc')->pluck('order_id')->first();
        $labour_charge_4p = DB::table('labour_charges')
            ->select('amount')
            ->where('labour_charge_id', 1)
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->first();
        $labour_charge_rough = DB::table('labour_charges')
            ->select('amount')
            ->where('is_active', 1)
            ->where('labour_charge_id', 2)
            ->where('is_deleted', 0)
            ->first();
        $customers = DB::table('customer')
            ->select('customer_id', 'name', 'email')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('customer_id', 'asc')
            ->get();
        $country = DB::table('country')
            ->select('country_id', 'name')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();
        $payment_modes = DB::table('payment_modes')->where('is_active', 1)->where('is_deleted', 0)->get();
        return view('admin.orders.invoice', compact('data', 'customers', 'payment_modes', 'country', 'order_id', 'labour_charge_4p', 'labour_charge_rough'));
    }

    public function saveInvoice(Request $request)
    {
        $rules = [
            'customer_id' => ['required', 'integer', 'exists:customer,customer_id'],
            'barcode' => ['required', 'array'],
            'discounts' => ['required', 'array'],
            'billing_id' => ['required', 'integer'],
            'shipping_id' => ['required', 'integer']
        ];

        $message = [];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
        }

        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();
        $elastic_params = [
            'index' => 'diamonds',
            'size' => 50,
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['terms' => ['barcode' => $request['barcode']]],
                        ]
                    ]
                ]
            ]
        ];
        $diamonds = $client->search($elastic_params);
        if (!count($diamonds['hits']['hits'])) {
            return response()->json(['error' => 1, 'message' => 'Something went wrong']);
        }
        $labour_charge_4p = DB::table('labour_charges')
            ->select('amount')
            ->where('labour_charge_id', 1)
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->first();
        $labour_charge_rough = DB::table('labour_charges')
            ->select('amount')
            ->where('is_active', 1)
            ->where('labour_charge_id', 2)
            ->where('is_deleted', 0)
            ->first();

        $subtotal = $weight = 0;
        foreach ($diamonds['hits']['hits'] as $v) {
            $v = $v['_source'];
            if (($v['discount'] * 100) == $request['discounts'][$v['barcode']]) {
                $subtotal += $v['total'];
            } else {
                if ($v['refCategory_id'] == 3) {
                    $subtotal += $v['rapaport_price'] * $v['expected_polish_cts'] * ((100 - $request['discounts'][$v['barcode']]) / 100);
                } else if ($v['refCategory_id'] == 2) {
                    $subtotal += ($v['rapaport_price'] * $v['expected_polish_cts'] * ((100 - $request['discounts'][$v['barcode']]) / 100)) - ($v['expected_polish_cts'] * $labour_charge_4p->amount);
                } else {
                    $subtotal += (($v['rapaport_price'] * $v['expected_polish_cts'] * ((100 - $request['discounts'][$v['barcode']]) / 100) / $v['makable_cts']) - $labour_charge_rough->amount) * $v['makable_cts'];
                }
            }
            $weight += $v['expected_polish_cts'];
        }
        $subtotal = round($subtotal, 2);
        $shipping_info = DB::table('customer_company_details')
            ->select('customer_company_id', 'name', 'office_no', 'official_email', 'office_address', 'pincode', 'refCity_id', 'refState_id', 'refCountry_id', 'pan_gst_no')
            ->where('customer_company_id', $request['shipping_id'])
            ->first();

        $billing_info = DB::table('customer_company_details')
            ->select('customer_company_id', 'name', 'office_no', 'official_email', 'office_address', 'pincode', 'refCity_id', 'refState_id', 'refCountry_id', 'pan_gst_no')
            ->where('customer_company_id', $request['billing_id'])
            ->first();

        $discount = DB::table('discounts')
            ->select('discount_id', 'name', 'discount')
            ->where('from_amount', '<=', intval($subtotal))
            ->where('to_amount', '>=', intval($subtotal))
            ->first();

        $additional_discount = DB::table('customer as c')
            ->join('customer_type as ct', 'c.refCustomerType_id', '=', 'ct.customer_type_id')
            ->select('ct.discount')
            ->where('c.customer_id', $request['customer_id'])
            ->pluck('discount')
            ->first();

        $tax = DB::table('customer as c')
            ->join('customer_company_details as ccd', 'c.customer_id', '=', 'ccd.refCustomer_id')
            ->join('taxes as t', 'ccd.refCountry_id', '=', 't.refCountry_id')
            ->select('t.tax_id', 't.name', 't.amount')
            ->where('c.customer_id', $request['customer_id'])
            ->where('ccd.customer_company_id', $request['shipping_id'])
            ->first();

        $shipping = DB::table('delivery_charges')
            ->select('delivery_charge_id', 'name', 'amount')
            ->where('from_weight', '<=', intval($weight))
            ->where('to_weight', '>=', (intval($weight) + 1))
            ->first();

        $customer = DB::table('customer')
            ->select('customer_id', 'name', 'mobile', 'email')
            ->where('customer_id', $request['customer_id'])
            ->first();

        $overall_discount = !empty($discount) ? (($subtotal * $discount->discount) / 100) : 0;
        $additional_discount = !empty($additional_discount) ? (($subtotal * $additional_discount) / 100) : 0;
        $final_tax = !empty($tax) ? (($subtotal * $tax->amount) / 100) : 0;
        $shipping_charge = !empty($shipping) ? $shipping->amount : 0;
        $total = $subtotal - round($overall_discount, 2) - round($additional_discount, 2) + round($final_tax, 2) + $shipping_charge;

        if ($request['invoice_date']) {
            $invoice_date = $request['invoice_date'];
        } else {
            $invoice_date = date('Y-m-d H:i:s');
        }

        $order = new Order;
        $order->refCustomer_id = $customer->customer_id;
        $order->name = $customer->name;
        $order->mobile_no = $customer->mobile;
        $order->email_id = $customer->email;
        $order->refPayment_mode_id = 1;
        $order->payment_mode_name = 'COD';
        $order->refTransaction_id = mt_rand(111111, 999999);
        $order->refCustomer_company_id_billing = $billing_info->customer_company_id;
        $order->billing_company_name = $billing_info->name;
        $order->billing_company_office_no = $billing_info->office_no;
        $order->billing_company_office_email = $billing_info->official_email;
        $order->billing_company_office_address = $billing_info->office_address;
        $order->billing_company_office_pincode = $billing_info->pincode;
        $order->refCity_id_billing = $billing_info->refCity_id;
        $order->refState_id_billing = $billing_info->refState_id;
        $order->refCountry_id_billing = $billing_info->refCountry_id;
        $order->billing_company_pan_gst_no = $billing_info->pan_gst_no;
        $order->refCustomer_company_id_shipping = $shipping_info->customer_company_id;
        $order->shipping_company_name = $shipping_info->name;
        $order->shipping_company_office_no = $shipping_info->office_no;
        $order->shipping_company_office_email = $shipping_info->official_email;
        $order->shipping_company_office_address = $shipping_info->office_address;
        $order->shipping_company_office_pincode = $shipping_info->pincode;
        $order->refCity_id_shipping = $shipping_info->refCity_id;
        $order->refState_id_shipping = $shipping_info->refState_id;
        $order->refCountry_id_shipping = $shipping_info->refCountry_id;
        $order->shipping_company_pan_gst_no = $shipping_info->pan_gst_no;
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
        $order->total_paid_amount = round($total, 2);
        $order->added_by = $request->session()->get('loginId');
        $order->order_type = 0;
        $order->shipping_remarks = $request['shipping_remarks'];
        $order->billing_remarks = $request['company_remarks'];
        $order->date_added = $invoice_date;
        $order->date_updated = $invoice_date;
        $order->created_at = $invoice_date;
        $order->updated_at = $invoice_date;
        $order->save();

        DB::table('order_updates')
        ->insert([
            'order_status_name' => 'PAID',
            'refOrder_id' => $order->order_id,
            'comment' => 'comment',
            'added_by' => 0,
            'is_deleted' => 0,
            'date_added' => $invoice_date,
            'created_at' => $invoice_date,
            'updated_at' => $invoice_date
        ]);

        $od = $d_ids = [];
        $params = [];
        foreach ($diamonds['hits']['hits'] as $v) {
            $v = $v['_source'];
            if (($v['discount'] * 100) == $request['discounts'][$v['barcode']]) {
                $price = $v['total'];
                $discount_ = $v['discount'];
            } else {
                if ($v['refCategory_id'] == 3) {
                    $price = $v['rapaport_price'] * $v['expected_polish_cts'] * ((100 - $request['discounts'][$v['barcode']]) / 100);
                } else if ($v['refCategory_id'] == 2) {
                    $price = ($v['rapaport_price'] * $v['expected_polish_cts'] * ((100 - $request['discounts'][$v['barcode']]) / 100)) - ($v['expected_polish_cts'] * $labour_charge_4p->amount);
                } else {
                    $price = (($v['rapaport_price'] * $v['expected_polish_cts'] * ((100 - $request['discounts'][$v['barcode']]) / 100) / $v['makable_cts']) - $labour_charge_rough->amount) * $v['makable_cts'];
                }
                $discount_ = $request['discounts'][$v['barcode']] / 100;
            }

            $params["body"][] = [
                "delete" => [
                    "_index" => 'diamonds',
                    "_id" => 'd_id_' . $v['diamond_id'],
                ]
            ];
            $d_ids[] = $v['diamond_id'];
            $od[] = [
                'refOrder_id' => $order->order_id,
                'refDiamond_id' => $v['diamond_id'],
                'name' => $v['name'],
                'price' => $price,
                'barcode' => $v['barcode'],
                'makable_cts' => $v['makable_cts'],
                'expected_polish_cts' => $v['expected_polish_cts'],
                'remarks' => $v['remarks'],
                'rapaport_price' => $v['rapaport_price'],
                'discount' => $discount_,
                'weight_loss' => $v['weight_loss'],
                'video_link' => $v['video_link'],
                'images' => json_encode($v['image']),
                'refCategory_id' => $v['refCategory_id'],
                'created_at' => $invoice_date,
                'updated_at' => $invoice_date
            ];

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
                    'created_at' => date("Y-m-d h:i:s"),
                    'updated_at' => date("Y-m-d h:i:s")
                ]);
            }
        }

        $client->bulk($params);

        DB::table('diamonds')->whereIn('diamond_id', $d_ids)->decrement('available_pcs', 1);

        DB::table('order_diamonds')->insert($od);

        DB::table('customer_cart')->where('refCustomer_id', $customer->customer_id)->delete();
        activity($request, "inserted", 'orders', $order->order_id);

        return response()->json(['success' => 1, 'message' => 'Order added successfully']);
    }
}
