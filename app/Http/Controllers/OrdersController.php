<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Orders;
use DataTables;

class OrdersController extends Controller
{
    public function index() {
        $data['title'] = 'List-Orders';
        return view('admin.orders.list', ["data" => $data]);
    }
    public function list(Request $request) {
        if ($request->ajax()) {
            
            $data = DB::table('orders')->select('orders.order_id','orders.name','orders.mobile_no','orders.email_id','orders.payment_mode_name','orders.refTransaction_id','orders.total_paid_amount','orders.date_added','orders.date_updated')->latest()->orderBy('order_id','desc')->get();
            return Datatables::of($data)
                            ->addColumn('index','')
                            ->editColumn('date_updated', function ($row) {
                                return date_formate($row->date_updated);
                            })
                            ->editColumn('date_added', function ($row) {
                                return date_formate($row->date_added);
                            })
                            ->addColumn('action', function ($row) {
                                $actionBtn = '<a href="/admin/orders/edit/' . $row->order_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }  
    
    
    public function edit($id) {        
        $result = DB::table('orders')->where('order_id', $id)->first();
        $address_list = DB::table('customer_company_details')->select('customer_company_details.*', 'city.name as city_name','state.name as state_name','country.name as country_name')
                ->leftJoin('city', 'city.city_id', '=', 'customer_company_details.refCity_id')
                ->leftJoin('state', 'state.state_id', '=', 'customer_company_details.refState_id')
                ->leftJoin('country', 'country.country_id', '=', 'customer_company_details.refCountry_id')
                ->where('refCustomer_id', $result->refCustomer_id)->get();
        $data['title'] = 'Edit-Orders';
        $data['address_list'] = $address_list;
        $data['result'] = $result;
        return view('admin.orders.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        
        $shipping_address = DB::table('customer_company_details')->select('customer_company_details.*', 'city.name as city_name','state.name as state_name','country.name as country_name')
                ->leftJoin('city', 'city.city_id', '=', 'customer_company_details.refCity_id')
                ->leftJoin('state', 'state.state_id', '=', 'customer_company_details.refState_id')
                ->leftJoin('country', 'country.country_id', '=', 'customer_company_details.refCountry_id')
                ->where('customer_company_id', $request->refCustomer_company_id_shipping)->first();
        
        $billing_address = DB::table('customer_company_details')->select('customer_company_details.*', 'city.name as city_name','state.name as state_name','country.name as country_name')
              ->leftJoin('city', 'city.city_id', '=', 'customer_company_details.refCity_id')
              ->leftJoin('state', 'state.state_id', '=', 'customer_company_details.refState_id')
              ->leftJoin('country', 'country.country_id', '=', 'customer_company_details.refCountry_id')
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
        activity($request,"updated",'orders',$request->id);
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/orders');
    }
        
    public function status(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_active' => $request['status'],
                'date_updated' => date("Y-m-d h:i:s")
            ]);
//            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            activity($request,"updated",$request['module'],$request['table_id']);
            return response()->json($data);
        }
    }
}
