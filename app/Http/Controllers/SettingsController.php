<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Settings;
use DataTables;

class SettingsController extends Controller {

    public function index() {
        $data['title'] = 'List-Settings';
        return view('admin.settings.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Settings';
        return view('admin.settings.add', ["data" => $data]);
    }

    public function save(Request $request) {
        DB::table('settings')->insert([
            'key' => $request->key,
            'value' => $request->value,
            'updated_by' => $request->session()->get('loginId'),            
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        
        activity($request,"inserted",'settings');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('settings');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Settings::latest()->orderBy('setting_id','desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
//                    ->editColumn('is_deleted', function ($row) {
//                                $delete_button='';
//                                if($row->is_deleted==1){
//                                    $delete_button='<span class="badge badge-danger">Deleted</span>';
//                                }
//                                return $delete_button;
//                            })
                            ->addColumn('action', function ($row) {
                                $actionBtn = '<a href="/settings/edit/' . $row->setting_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('settings')->where('setting_id', $id)->first();
        $data['title'] = 'Edit-Settings';
        $data['result'] = $result;
        return view('admin.settings.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('settings')->where('setting_id', $request->id)->update([
            'key' => $request->key,
            'value' => $request->value,
            'updated_by' => $request->session()->get('loginId'),            
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        
        activity($request,"updated",'settings');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('settings');
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


