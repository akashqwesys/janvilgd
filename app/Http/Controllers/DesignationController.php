<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Designation;
use DataTables;

class DesignationController extends Controller {

    public function index() {
        $data['title'] = 'List-Dasignation';
        return view('admin.designation.designation_list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Dasignation';
        return view('admin.designation.add_designation', ["data" => $data]);
    }
    public function save(Request $request) {
        DB::table('designation')->insert([
            'name' => $request->name,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        activity($request,"inserted",'designation');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('designation');
    }
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Designation::latest()->orderBy('id','desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index','')
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
                                
                                $actionBtn = '<a href="/designation/edit/' . $row->id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="designation" data-id="' . $row->id . '" data-table="designation" data-wherefield="id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->id . '" data-status="' . $row->is_active . '" data-table="designation" data-wherefield="id" data-module="designation">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $designation = DB::table('designation')->where('id', $id)->first();
        $data['title'] = 'Edit-Dasignation';
        $data['designation'] = $designation;
        return view('admin.designation.edit_designation', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('designation')->where('id', $request->id)->update([
            'name' => $request->name,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,                       
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        activity($request,"updated",'designation');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('designation');
    }
    public function delete(Request $request) {
        if (isset($_REQUEST['table_id'])) {
            
            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([                                              
                'is_deleted' => 1,                                
                'date_updated' => date("yy-m-d h:i:s")
            ]); 
            activity($request,"deleted",$_REQUEST['module']);
//            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
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
        if (isset($_REQUEST['table_id'])) {
            
            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([                                              
                'is_active' => $_REQUEST['status'],                                
                'date_updated' => date("yy-m-d h:i:s")
            ]);                        
//            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            activity($request,"updated",$_REQUEST['module']);
            return response()->json($data);
        }
    }
}
