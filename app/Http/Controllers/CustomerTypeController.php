<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\CustomerType;
use DataTables;

class CustomerTypeController extends Controller {

    public function index() {
        $data['title'] = 'List-Customer-Type';
        return view('admin.customerType.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Customer-Type';
        return view('admin.customerType.add', ["data" => $data]);
    }

    public function save(Request $request) {
        DB::table('customer_type')->insert([
            'name' => $request->name,
            'discount' => $request->discount,
            'allow_credit' => $request->allow_credit,
            'credit_limit' => $request->credit_limit,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-d h:i:s")
        ]);

        activity($request,"inserted",'customer-type');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('customer-type');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = CustomerType::select('customer_type_id', 'name', 'discount', 'allow_credit', 'credit_limit', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('customer_type_id','desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
                            ->editColumn('is_active', function ($row) {
                                $active_inactive_button='';
                                if($row->is_active==1){
                                    $active_inactive_button='<span class="badge badge-success">Active</span>';
                                }
                                if($row->is_active==0){
                                    $active_inactive_button='<span class="badge badge-danger">inActive</span>';
                                }
                                return $active_inactive_button;
                            })
                            ->editColumn('is_deleted', function ($row) {
                                $delete_button='';
                                if($row->is_deleted==1){
                                    $delete_button='<span class="badge badge-danger">Deleted</span>';
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

                                $actionBtn = '<a href="/customer-type/edit/' . $row->customer_type_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="customer-type" data-id="' . $row->customer_type_id . '" data-table="customer_type" data-wherefield="customer_type_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->customer_type_id . '" data-status="' . $row->is_active . '" data-table="customer_type" data-wherefield="customer_type_id" data-module="customer-type">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->rawColumns(['action'])
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('customer_type')->select('customer_type_id', 'name', 'discount', 'allow_credit', 'credit_limit', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('customer_type_id', $id)->first();
        $data['title'] = 'Edit-Customer-Type';
        $data['result'] = $result;
        return view('admin.customerType.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('customer_type')->where('customer_type_id', $request->id)->update([
            'name' => $request->name,
            'discount' => $request->discount,
            'allow_credit' => $request->allow_credit,
            'credit_limit' => $request->credit_limit,
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        activity($request,"updated",'customer-type');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('customer-type');
    }
    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("yy-m-d h:i:s")
            ]);
            activity($request,"deleted",$request['module']);
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
                'date_updated' => date("yy-m-d h:i:s")
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
            activity($request,"updated",$request['module']);
            return response()->json($data);
        }
    }
}
