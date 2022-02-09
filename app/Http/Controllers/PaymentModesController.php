<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\PaymentModes;
use DataTables;

class PaymentModesController extends Controller {

    public function index() {
        $data['title'] = 'List-Payment-Modes';
        return view('admin.paymentModes.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Payment-Modes';
        return view('admin.paymentModes.add', ["data" => $data]);
    }

    public function save(Request $request) {
        DB::table('payment_modes')->insert([
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d H:i:s"),
            'date_updated' => date("Y-m-d H:i:s")
        ]);
        $Id = DB::getPdo()->lastInsertId();
        activity($request,"inserted",'payment-modes',$Id);
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/payment-modes');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = PaymentModes::select('payment_mode_id', 'name', 'sort_order', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('payment_mode_id','desc')->get();
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

                                if($row->is_active==1){
                                    $str='<em class="icon ni ni-cross"></em>';
                                    $class="btn-danger";
                                }
                                if($row->is_active==0){
                                    $str='<em class="icon ni ni-check-thick"></em>';
                                    $class="btn-success";
                                }

                                $actionBtn = '<a href="/admin/payment-modes/edit/' . $row->payment_mode_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="payment-modes" data-id="' . $row->payment_mode_id . '" data-table="payment_modes" data-wherefield="payment_mode_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->payment_mode_id . '" data-status="' . $row->is_active . '" data-table="payment_modes" data-wherefield="payment_mode_id" data-module="payment-modes">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('payment_modes')->select('payment_mode_id', 'name', 'sort_order', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('payment_mode_id', $id)->first();
        $data['title'] = 'Edit-Payment-Modes';
        $data['result'] = $result;
        return view('admin.paymentModes.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('payment_modes')->where('payment_mode_id', $request->id)->update([
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'date_updated' => date("Y-m-d H:i:s")
        ]);
        activity($request,"updated",'payment-modes',$request->id);
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/payment-modes');
    }
    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d H:i:s")
            ]);
            activity($request,"deleted",$request['module'],$request['table_id']);
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
            activity($request,"updated",$request['module'],$request['table_id']);
            return response()->json($data);
        }
    }
}
