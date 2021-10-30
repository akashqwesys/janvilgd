<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\UserRoles;
use DataTables;

class UserRolesController extends Controller {

    public function index() {
        $data['title'] = 'List-User-Roles';
        return view('admin.userRoles.list', ["data" => $data]);
    }
    public function add() {
        $module = DB::table('modules')->select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'sort_order')->where('is_active',1)->where('is_deleted',0)->where('parent_id','>',0)->get();
        $data['module'] = $module;
        $data['title'] = 'Add-User-Roles';
        return view('admin.userRoles.add', ["data" => $data]);
    }

    public function save(Request $request) {
        $access_permission= json_encode($request->access_permission);
        $modify_permission= json_encode($request->modify_permission);
        DB::table('user_role')->insert([
            'name' => $request->name,
            'access_permission' => $access_permission,
            'modify_permission' => $modify_permission,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d h:i:s"),
            'date_updated' => date("Y-m-d h:i:s")
        ]);

        activity($request,"inserted",'user-role');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/user-role');
    }

    public function list(Request $request) {
        if ($request->ajax()) {              
//            $data = DB::table('diamonds')->select('diamonds.*', 'categories.name as category_name')->leftJoin('categories', 'diamonds.refCategory_id', '=', 'categories.category_id')->where('refCategory_id', $request->refCategory_id)->orderBy('diamond_id', 'desc')->get();                        
//            $data = DB::table('user_role')->select('user_role.*', 'users.role_id')->leftJoin('users', 'user_role.user_role_id', '=', 'users.role_id')->get();            
            $data = UserRoles::select('user_role_id', 'name', 'access_permission', 'modify_permission', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('user_role_id','desc')->get();
            
//            print_r($data);die;
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
                    ->editColumn('date_added', function ($row) {                                
                                return date_formate($row->date_added);
                            })
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

                                $actionBtn = '<a href="/admin/user-role/edit/' . $row->user_role_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> ';
//                                if(in_array($row->user_role_id,$array_data)){
//                                    
//                                }else{
                                    $actionBtn.= '<button class="btn btn-xs btn-danger delete_button" data-module="user-role" data-id="' . $row->user_role_id . '" data-table="user_role" data-wherefield="user_role_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button>';
                                    $actionBtn.= ' <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->user_role_id . '" data-status="' . $row->is_active . '" data-table="user_role" data-wherefield="user_role_id" data-module="user-role">'.$str.'</button>';
//                                }
                                return $actionBtn;
                            })
                            ->rawColumns(['action'])
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $module = DB::table('modules')->select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'sort_order')->where('is_active',1)->where('is_deleted',0)->where('parent_id','>',0)->get();
        $result = DB::table('user_role')->select('user_role_id', 'name', 'access_permission', 'modify_permission', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('user_role_id', $id)->first();
        $data['module'] = $module;
        $data['title'] = 'Edit-User-Roles';
        $data['result'] = $result;
        return view('admin.userRoles.edit', ["data" => $data]);
    }

    public function update(Request $request) {
//        echo json_encode($request->access_permission);die;
        $access_permission= json_encode($request->access_permission);
        $modify_permission= json_encode($request->modify_permission);
        DB::table('user_role')->where('user_role_id', $request->id)->update([
            'name' => $request->name,
            'access_permission' => $access_permission,
            'modify_permission' => $modify_permission,
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        activity($request,"updated",'user-role');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/user-role');
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


