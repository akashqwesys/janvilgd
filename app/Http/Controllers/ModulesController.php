<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Modules;
use DataTables;

class ModulesController extends Controller {

    public function index() {
        $data['title'] = 'List-Modules';
        return view('admin.modules.list', ["data" => $data]);
    }

    public function add() {
        $module = DB::table('modules')->where('is_active',1)->where('is_deleted',0)->where('parent_id',0)->get();       
        $data['title'] = 'Add-Modules';
        $data['module'] = $module;
        return view('admin.modules.add', ["data" => $data]);
    }

    public function save(Request $request) {        
        DB::table('modules')->insert([
            'name' => $request->name,
            'icon' => $request->icon,
            'slug' => clean_string($request->slug),
            'parent_id' => $request->parent_id,
            'sort_order' => $request->sort_order,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-d h:i:s")     
        ]);
        activity($request,"inserted",'modules');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('modules');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Modules::latest()->orderBy('module_id','desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
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
                                $actionBtn = '<a href="/modules/edit/' . $row->module_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="modules" data-id="' . $row->module_id . '" data-table="modules" data-wherefield="module_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->module_id . '" data-status="' . $row->is_active . '" data-table="modules" data-wherefield="module_id" data-module="modules">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $module  = DB::table('modules')->where('parent_id',0)->get();        
        $result = DB::table('modules')->where('module_id', $id)->first();
        $data['title'] = 'Edit-Modules';
        $data['result'] = $result;
        $data['module'] = $module;
        return view('admin.modules.edit', ["data" => $data]);
    }
    public function update(Request $request) {
        DB::table('modules')->where('module_id', $request->id)->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'slug' => clean_string($request->slug),
            'parent_id' => $request->parent_id,
            'sort_order' => $request->sort_order,
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        activity($request,"updated",'modules');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('modules');
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

