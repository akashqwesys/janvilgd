<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\DeliveryCharges;
use DataTables;

class DeliveryChargesController extends Controller {

    public function index() {
        $data['title'] = 'List-Delivery-Charges';
        return view('admin.deliveryCharges.list', ["data" => $data]);
    }

    public function add() {
        $transport = DB::table('transport')->select('transport_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['transport']=$transport;
        $data['title'] = 'Add-Delivery-Charges';
        return view('admin.deliveryCharges.add', ["data" => $data]);
    }

    public function save(Request $request) {
        $transport=explode('_', $request->reftransport_id);
        DB::table('delivery_charges')->insert([
            'name' => $request->name,
            'reftransport_id' => $transport[0],
            'transport_name' => $transport[1],
            'from_weight' => $request->from_weight,
            'to_weight' => $request->to_weight,
            'amount' => $request->amount,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d H:i:s"),
            'date_updated' => date("Y-m-d H:i:s")
        ]);

        activity($request, "inserted", 'delivery-charges');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/delivery-charges');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = DeliveryCharges::select('delivery_charge_id', 'name', 'reftransport_id', 'transport_name', 'from_weight', 'to_weight', 'amount', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('delivery_charge_id', 'desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
                            ->editColumn('date_added', function ($row) {
                                return date_formate($row->date_added);
                            })
                            ->editColumn('is_active', function ($row) {
                                $active_inactive_button = '';
                                if ($row->is_active == 1) {
                                    $active_inactive_button = '<span class="badge badge-success">Active</span>';
                                }
                                if ($row->is_active == 0) {
                                    $active_inactive_button = '<span class="badge badge-danger">inActive</span>';
                                }
                                return $active_inactive_button;
                            })
                            ->editColumn('is_deleted', function ($row) {
                                $delete_button = '';
                                if ($row->is_deleted == 1) {
                                    $delete_button = '<span class="badge badge-danger">Deleted</span>';
                                }
                                return $delete_button;
                            })
                            ->addColumn('action', function ($row) {
                                if ($row->is_active == 1) {
                                    $str = '<em class="icon ni ni-cross"></em>';
                                    $class = "btn-danger";
                                }
                                if ($row->is_active == 0) {
                                    $str = '<em class="icon ni ni-check-thick"></em>';
                                    $class = "btn-success";
                                }
                                $actionBtn = '<a href="/admin/delivery-charges/edit/' . $row->delivery_charge_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="delivery-charges" data-id="' . $row->delivery_charge_id . '" data-table="delivery_charges" data-wherefield="delivery_charge_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs ' . $class . ' active_inactive_button" data-id="' . $row->delivery_charge_id . '" data-status="' . $row->is_active . '" data-table="delivery_charges" data-wherefield="delivery_charge_id" data-module="blogs">' . $str . '</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $transport = DB::table('transport')->select('transport_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['transport']=$transport;

        $result = DB::table('delivery_charges')->where('delivery_charge_id', $id)->first();
        $data['title'] = 'Edit-Delivery-Charges';
        $data['result'] = $result;
        return view('admin.deliveryCharges.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        $transport=explode('_', $request->reftransport_id);
        DB::table('delivery_charges')->where('delivery_charge_id', $request->id)->update([
            'name' => $request->name,
            'reftransport_id' => $transport[0],
            'transport_name' => $transport[1],
            'from_weight' => $request->from_weight,
            'to_weight' => $request->to_weight,
            'amount' => $request->amount,
            'date_updated' => date("Y-m-d H:i:s")
        ]);
        activity($request, "updated", 'delivery-charges');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/delivery-charges');
    }

    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d H:i:s")
            ]);
            activity($request, "deleted", $request['module']);
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
            return response()->json($data);
        }
    }

    public function status(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_active' => $request['status'],
                'date_updated' => date("Y-m-d H:i:s")
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
            activity($request, "updated", $request['module']);
            return response()->json($data);
        }
    }

}
