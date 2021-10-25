<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Discounts;
use DataTables;

class DiscountsController extends Controller {

    public function index() {
        $data['title'] = 'List-Discount';
        return view('admin.discount.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Discount';
        return view('admin.discount.add', ["data" => $data]);
    }

    public function save(Request $request) {
        DB::table('discounts')->insert([
            'name' => $request->name,
            'from_amount' => $request->from_amount,
            'to_amount' => $request->to_amount,
            'discount' => $request->discount,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d h:i:s"),
            'date_updated' => date("Y-m-d h:i:s")
        ]);

        activity($request,"inserted",'discount');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/discount');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Discounts::select('discount_id', 'name', 'from_amount', 'to_amount', 'discount', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('discount_id','desc')->get();
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
                                $actionBtn = '<a href="/admin/discount/edit/' . $row->discount_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="discount" data-id="' . $row->discount_id . '" data-table="discounts" data-wherefield="discount_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->discount_id . '" data-status="' . $row->is_active . '" data-table="discounts" data-wherefield="discount_id" data-module="discount">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('discounts')->select('discount_id', 'name', 'from_amount', 'to_amount', 'discount', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('discount_id', $id)->first();
        $data['title'] = 'Edit-Discounts';
        $data['result'] = $result;
        return view('admin.discount.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('discounts')->where('discount_id', $request->id)->update([
            'name' => $request->name,
            'from_amount' => $request->from_amount,
            'to_amount' => $request->to_amount,
            'discount' => $request->discount,
            'date_updated' => date("Y-m-d h:i:s")
        ]);

        activity($request,"updated",'discount');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/discount');
    }
    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d h:i:s")
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
            activity($request,"updated",$request['module']);
            return response()->json($data);
        }
    }

}
